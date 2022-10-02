<?php

namespace Modules\Finance\Http\Controllers\Invoice;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Contracts\AdminService;
use Modules\Base\Criteria\ListRequestCriteria;
use Modules\Finance\Contracts\InvoiceRepository;
use Modules\Finance\Http\Controllers\Controller;
use Modules\Finance\Http\Requests\Invoice\InvoiceDownloadRequest;
use Modules\Finance\Http\Resources\Invoice\InvoiceListResource;
use Modules\Finance\Services\InvoiceService;
use Modules\Finance\Http\Requests\Invoice\InvoiceIndexRequest;
use Modules\Finance\Jobs\DownloadClearAccounts;

class InvoiceController extends Controller
{
    /**
     * 返回发票列表
     * @param InvoiceIndexRequest $request
     * @param AdminService $adminService
     * @param InvoiceRepository $invoiceRepository
     * @param InvoiceService $invoiceService
     * @return InvoiceListResource
     */
    public function index(InvoiceIndexRequest $request, AdminService $adminService, InvoiceRepository $invoiceRepository, InvoiceService $invoiceService)
    {
        $filter = $request->input('filter');
        $user = Auth::user();
        if ($user->hasPermissionTo('finance.invoice.invoices.all')){
            $admins = [];
            $type = 1;
        } else if ($user->hasPermissionTo('finance.invoice.invoices.group')){
            $admins = $adminService->getGroupAdmins($user)->pluck('uuid')->all();
            $type = 2;
        } else {
            $admins = $user->uuid;
            $type = 3;
        }

        if($filter && isset($filter['key']) && $filter['key']){ // 走es查询逻辑
            $key = $filter['key'];
            $sort = $request->input('sort') ?? [];
            $sort = $sort['created_at'] ?? "DESC";
            $lists = $invoiceRepository->getTypeIndexByES($type, $request->input('limit'), $key, $admins, $sort);
        } else {
            $invoiceRepository->pushCriteria(new ListRequestCriteria($request));
            $lists = $invoiceRepository->getTypeIndex($type, $request->input('limit'), $admins);
        }
        return new InvoiceListResource($lists, $invoiceService, $invoiceRepository);
    }

    /**
     * 返回发票详情
     * @param Request $request
     * @param InvoiceRepository $repository
     * @param InvoiceService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function relate(Request $request, InvoiceRepository $repository, InvoiceService $service)
    {
        $invoiceData = $repository->findSelf($request->uuid);
        if (is_null($invoiceData)) {
            return $this->failedWithMessage(__('finance::invoice.invoiceNotExists'));
        }
        $invoice = (new InvoiceListResource($invoiceData, $service, $repository))->toInvoiceDetail($invoiceData, 1);
        $credit_notes = $service->getInvoiceCreditNotes();
        $writeOffs = $service->getInvoiceWriteOffs();
        $concessionRes = $service->getInvoiceConcession($invoiceData);//获取坏账折让记录
        $discounts = $concessionRes['discounts'];
        $bad_debts = $concessionRes['bad_debts'];
        return $this->successWithData(compact('invoice', 'credit_notes', 'writeOffs', 'discounts', 'bad_debts'));
    }

    /**
     * 导出清账表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearDownload(InvoiceDownloadRequest $request)
    {
        $user = Auth::user();
        if (empty($user->email)) {
            return $this->failedWithMessage(__('finance::common.hasNotSetEmail'));
        }
        dispatch(new DownloadClearAccounts($request->input()));
        return $this->successWithMessage(__('finance::receipt.downloadInQueue'));
    }

}
