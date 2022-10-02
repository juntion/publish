<?php

namespace Modules\Finance\Http\Controllers\Invoice;

use Illuminate\Support\Facades\DB;
use Modules\ERP\Contracts\ProductsInstockShippingApplyRepository;
use Modules\ERP\Service\RechnungInvoiceService;
use Modules\Finance\Contracts\InvoiceRepository;
use Modules\Finance\Contracts\ReceiptService;
use Modules\Finance\Exceptions\InvoiceException;
use Modules\Finance\Http\Controllers\Controller;
use Modules\Finance\Http\Requests\Invoice\ClearInvoiceRequest;
use Modules\Finance\Http\Requests\Invoice\UnclearedInvoiceRequest;
use Modules\Finance\Http\Requests\Invoice\CreateInvoiceRequest;
use Modules\Finance\Http\Requests\Invoice\DeleteInvoiceRequest;
use Modules\Finance\Http\Resources\Invoice\InvoiceResource;
use Modules\Finance\Http\Resources\Invoice\InvoiceUnclearedResource;
use Modules\Finance\Services\InvoiceService;
use Modules\Base\Contracts\Company\CompanyRepository;

class InvoiceApiController extends Controller
{
    /**
     * 创建发票
     *
     * @param CreateInvoiceRequest $request
     * @param InvoiceRepository $invoiceMainRepo
     * @param InvoiceService $service
     * @return InvoiceResource
     * @throws InvoiceException
     */
    public function store(
        CreateInvoiceRequest $request,
        InvoiceRepository $invoiceMainRepo,
        InvoiceService $service,
        CompanyRepository $companyRepository,
        RechnungInvoiceService $rechnungInvoiceService,
        ProductsInstockShippingApplyRepository $applyRepository
    )
    {
        $invoice = $invoiceMainRepo->getErpProductsInvoice($request->invoice_number);
        if (empty($invoice)) throw new InvoiceException(__('finance::invoice.invoiceNotExists'));
        if (!in_array($invoice->type, [1, 2, 6])) throw new InvoiceException(__('finance::invoice.invoiceTypeError'));

        $productsInstockRes = $invoiceMainRepo->getErpProductsInstockShippingData($invoice->relate_id, $invoice->type);
        $productsInstockArr = $productsInstockRes->toArray();
        $productsInstock = $productsInstockRes->shift();
        if (empty($productsInstock)) throw new InvoiceException(__('finance::invoice.orderNotExists'));

        $assistantData = $invoiceMainRepo->getErpAssistantData($productsInstock->assistant_id);//发票对应的销售
        if (empty($assistantData)) throw new InvoiceException(__('finance::invoice.salesNotExists'));

        $company = $service::invoiceCompanyInfo($productsInstock, $companyRepository);//公司id
        $customer = $service::invoiceCustomerInfo($productsInstock, $applyRepository);
        $others = $service::invoiceAdditionalInfo($request, $invoice, $assistantData);

        $isAccount = $rechnungInvoiceService->instocKIsAccount($productsInstockArr);//是否为账期单
        $others['account_days'] = $isAccount==1?$service::toAccountPeriodCalculation($customer['customer_company_number']):($isAccount==2?30:0);
        $others['amount'] = round(array_sum(array_column($productsInstockArr, 'order_price')) * 100);
        $others['currency'] = $service->getCurrenciesCode($productsInstock->symbol_left);

        $data = array_merge($company, $customer, $others);
        $save = $invoiceMainRepo->toSave($data);//生成发票
        $service->invoiceReceiptClear($productsInstock, null, $data);//核销、清账

        return new InvoiceResource($save);
    }

    /**
     * 发票作废
     * @param DeleteInvoiceRequest $request
     * @param InvoiceRepository $invoiceMainRepo
     * @return \Illuminate\Http\JsonResponse
     * @throws InvoiceException
     */
    public function soft(DeleteInvoiceRequest $request, InvoiceRepository $invoiceMainRepo)
    {
        $invoice = $invoiceMainRepo->getDataByNumber($request->invoice_number);
        if (empty($invoice)) throw new InvoiceException(__('finance::invoice.invoiceNotExists'));

        //$delete = $invoiceMainRepo->softDelete(['number' => $request->invoice_number]);
        $update = $invoiceMainRepo->toUpdate(['number' => $request->invoice_number], ['to_void' => 1]);
        if (!$update) throw new InvoiceException(__('finance::invoice.invoiceSoftError'));

        return $this->successWithMessage(__('finance::invoice.invoiceSoftSuccess'));
    }

    /**
     * 清账
     * @param ClearInvoiceRequest $request
     * @param InvoiceService $service
     * @param InvoiceRepository $repository
     * @throws InvoiceException
     */
    public function clear(ClearInvoiceRequest $request, InvoiceService $service, InvoiceRepository $repository,ReceiptService $receiptService)
    {
        $invoice = $repository->getDataByNumber($request->expend_number);
        if (empty($invoice)) throw new InvoiceException(__('finance::invoice.invoiceNotExists'));
        DB::beginTransaction();
        try{
            if ($request->action_type == 1 && $request->flag) {
                $invoiceClear = $service->invoiceClear($invoice, $request, $receiptService);
            } else {
                $incomeClear = $request->flag?$request->income_clear:-$request->income_clear;
                $alreadyClear = $invoice->cleared + $incomeClear;//已核销金额+红冲金额
                if ($alreadyClear > $invoice->amount || $alreadyClear < 0) {
                    throw new InvoiceException(__('finance::invoice.clearAmountError'));
                }
                $invoiceClear = $service->createClearAccounts($invoice, $request, '', 0);
                $repository->invoiceClearedUpdate(['uuid' => $invoice->uuid], $incomeClear);//更新发票已核销金额
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            if($exception instanceof InvoiceException) {
                throw $exception;
            } else {
                throw new InvoiceException(__('finance::invoice.programError'), 400, $exception);
            }
        }
        $newInvoice = $repository->getDataByNumber($request->expend_number);
        return new InvoiceResource($newInvoice);
    }


    /**
     * 返回客户未清发票信息
     * @param DeleteInvoiceRequest $request
     * @param InvoiceRepository $invoiceMainRepo
     * @return InvoiceUnclearedResource
     * @throws InvoiceException
     */
    public function customerUncleared(UnclearedInvoiceRequest $request, InvoiceRepository $invoiceMainRepo)
    {
        $where = [
            ['customer_company_number', '=', $request->customer_company_number],
            ['amount', '>', 'cleared']
        ];
        $invoice = $invoiceMainRepo->getInvoiceAllByIdType($where);
        return new InvoiceUnclearedResource($invoice);
    }
}
