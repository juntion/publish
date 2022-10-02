<?php

namespace Modules\Finance\Http\Controllers\Voucher;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Admin\Contracts\AdminService;
use Modules\Admin\Entities\Admin;
use Modules\Base\Contracts\Company\CompanyRepository;
use Modules\Base\Criteria\ListRequestCriteria;
use Modules\Base\Entities\Model;
use Modules\Base\Support\Facades\Number;
use Modules\ERP\Contracts\CustomerCompanyRepository;
use Modules\ERP\Contracts\CustomerRepository;
use Modules\ERP\Contracts\InstockShippingRepository;
use Modules\ERP\Contracts\OrderCustomerCompanyService;
use Modules\ERP\Contracts\OrderPIRepository;
use Modules\ERP\Contracts\OrderRepository;
use Modules\ERP\Contracts\PaymentMethodRepository;
use Modules\ERP\Contracts\PaymentMethodService;
use Modules\ERP\Service\OrderService;
use Modules\ERP\Service\PaymentRelateOrdersService;
use Modules\ERP\Service\RechnungInvoiceService;
use Modules\ERP\Contracts\ProductsInstockShippingService;
use Modules\ERP\Service\ProductsInstockShippingApplyService;
use Modules\ERP\Support\Facades\Exchange;
use Modules\Finance\Contracts\InvoiceService;
use Modules\Finance\Contracts\PaymentReceiptsVouchersDetailRepository;
use Modules\Finance\Contracts\ReceiptRepository;
use Modules\Finance\Contracts\ReceiptsVouchersRepository;
use Modules\Finance\Contracts\VoucherRepository;
use Modules\Finance\Entities\PaymentReceipt;
use Modules\Finance\Exceptions\VoucherException;
use Modules\Finance\Http\Controllers\Controller;
use Modules\Finance\Http\Requests\Voucher\ApiRevokeRequest;
use Modules\Finance\Http\Requests\Voucher\ApiSplitRequest;
use Modules\Finance\Http\Requests\Voucher\ApiVoucherStoreRequest;
use Modules\Finance\Http\Requests\Voucher\CreateVoucherRequest;
use Modules\Finance\Http\Requests\Voucher\VoucherListDownloadRequest;
use Modules\Finance\Http\Requests\Voucher\VoucherListRequest;
use Modules\Finance\Http\Resources\Voucher\VoucherListCollectionResource;
use Modules\Finance\Http\Resources\Voucher\VoucherResource;
use Modules\Finance\Jobs\DownloadVoucherList;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class VoucherController extends Controller
{

    protected $accountPeriodMethod = [];

    /**
     * @param  CreateVoucherRequest  $request
     * @param  VoucherRepository  $repository
     * @param  ReceiptRepository  $receiptRepository
     * @param  OrderCustomerCompanyService  $service
     * @param  OrderRepository  $orderRepository
     * @param  OrderPIRepository  $PIRepository
     * @param  CustomerCompanyRepository  $customerCompanyRepository
     * @param  PaymentMethodRepository  $paymentMethodRepository
     * @param  InstockShippingRepository  $instockShippingRepository
     * @param  OrderService  $orderService
     * @return \Illuminate\Http\JsonResponse
     * @throws VoucherException
     * @throws \Modules\ERP\Exceptions\OrderException
     */
    public function store(
        CreateVoucherRequest $request,
        VoucherRepository $repository,
        ReceiptRepository $receiptRepository,
        OrderCustomerCompanyService $service,
        OrderRepository $orderRepository,
        OrderPIRepository $PIRepository,
        CustomerCompanyRepository $customerCompanyRepository,
        PaymentMethodRepository $paymentMethodRepository,
        InstockShippingRepository $instockShippingRepository,
        OrderService $orderService,
        PaymentReceiptsVouchersDetailRepository $paymentReceiptsVouchersDetailRepository,
        ProductsInstockShippingService $productsInstockShippingService,
        PaymentRelateOrdersService $paymentRelateOrdersService,
        RechnungInvoiceService $rechnungInvoiceService,
        InvoiceService $invoiceService,
        ProductsInstockShippingApplyService $shippingApplyService,
        AdminService $adminService
    ) {
        $DKInfo = $request->input('DK_info');
        $orderInfo = $request->input('order_info');
        $file = $request->file ?? [];
        if (count($DKInfo) > 1 && count($orderInfo) > 1) {
            throw new VoucherException(__('finance::voucher.onlyOneDataIsTwo'));
        }
        $vouchers = [];
        $user = Auth::user();

        $this->accountPeriodMethod = $paymentMethodRepository->getPaymentMethodsIDByType(2)->toArray();

        $numbers = collect($DKInfo)->pluck('number')->all();

        if ($user->hasPermissionTo('finance.receipt.receipts.all')){
            $admins = [];
            $type = 1;
        } else if ($user->hasPermissionTo('finance.receipt.receipts.group')){
            $admins = $adminService->getGroupAdmins($user)->pluck('uuid')->all();
            $type = 2;
        } else {
            $admins = $user->uuid;
            $type = 3;
        }


        $receipts = $receiptRepository->getReceiptByNumbersAndType($numbers, $type, $admins);

        if ($receipts->count() != count($numbers)) {
            throw new VoucherException(__('finance::voucher.receiptNotYoursOrUsed'));
        }

        if (count($DKInfo) > 1) { // 多个到款信息一个订单
            $data = $this->oneOrder2ManyReceipt(
                $request,
                $receipts,
                $orderRepository,
                $PIRepository,
                $service,
                $customerCompanyRepository,
                $instockShippingRepository,
                $orderService
            );
        } elseif (count($orderInfo) > 1) { // 多个订单一个到款信息
            $data = $this->manyOrder2OneReceipt(
                $request,
                $receipts,
                $orderRepository,
                $PIRepository,
                $service,
                $customerCompanyRepository,
                $instockShippingRepository,
                $orderService
            );
        } else { // 一个到款信息一个订单
            $data = $this->oneOrder2OneReceipt(
                $request,
                $receipts,
                $orderRepository,
                $PIRepository,
                $service,
                $customerCompanyRepository,
                $instockShippingRepository,
                $orderService
            );
        }

        DB::beginTransaction();
        try {
            $urls = [];
            foreach ($data as $item) {

                $voucherData = $item['voucherData'];
                $voucherData['remark'] = $request->input('remark');
                $voucherData['creator_uuid'] = $user->uuid;
                $voucherData['creator_name'] = $user->name;


                $voucher = $repository->storeVoucher($voucherData);
                $repository->addMedia($voucher, $file, 'voucher/');

                $allRelate = [];
                foreach ($item['relateData'] as $relate) {
                    $repository->relateReceipt($voucher, $relate);
                    $receipt = $receipts->firstWhere('number', $relate['receipt_number']);
                    $orderNeedDKPrice = $relate['receipt_use'];
                    $receiptRepository->useAmount($receipt, $orderNeedDKPrice);
                }

                if (isset($item['exchange'])) {
                    foreach ($item['exchange'] as $exchange) {
                        $receipt = $receiptRepository->find($exchange['uuid']);
                        $shippingApplyService->createFloatApplyByReceipt($receipt);
                    }
                }
                $instockData = [];
                $isInstock = $item['products_instock_id'];
                $orderNumber = $voucherData['order_number'];
                $isAccountPeriod = $item['isAccountPeriod'];
                $paymentVoucher = $voucher;
                $instockData['renling'] = 1;
                $instockData['isCustomerZone'] = $item['isCustomerZone'];
                $instockData['products_instock_id'] = $isInstock;
                $instockOrder = $productsInstockShippingService->createByVoucher($paymentVoucher,$instockData);//插入订单流程数据

                $isBk = Str::contains($orderNumber, "BK");

                if (($instockOrder->products_instock_id && $isInstock) || $isBk) { // 帐期单 或者 BK 直接使用 生成对应的detail
                    $this->accountPeriodSetDetail(
                        $paymentReceiptsVouchersDetailRepository,
                        $receiptRepository,
                        $instockShippingRepository,
                        $invoiceService,
                        $item['relateData'],
                        $item['products_instock_id'],
                        $orderNumber,
                        $user,
                        2
                    );
                    $paymentVoucher->related_id = $instockOrder->products_instock_id;
                    $relateOrderData = [];
                    $relateOrderData['products_instock_id'] = $isInstock;
                    $relateOrderData['related_id'] = $instockOrder->products_instock_id;
                    $erpRelate = $paymentRelateOrdersService->createByVoucher($paymentVoucher, $user,$relateOrderData);//插入订单流程数据
                    if ($erpRelate->id) { // 关联结清 判断是否账期单
                        $paymentVoucher->origin_id = $item['origin_id'];
                        $rechnungData = [
                            'origin_id' => $item['origin_id'],
                            'products_instock_id' => $isInstock
                        ];
                        $rechnungInvoiceService->revokeRechnungInvoice($paymentVoucher,$rechnungData);//账期额度归还
                    }
                } else if ($instockOrder->products_instock_id) {
                    $this->accountPeriodSetDetail(
                        $paymentReceiptsVouchersDetailRepository,
                        $receiptRepository,
                        $instockShippingRepository,
                        $invoiceService,
                        $item['relateData'],
                        $instockOrder->products_instock_id,
                        $orderNumber,
                        $user
                    );
                    if ($item['isOnline']) {
                        $urls[] = config('app.service_erp_url') . '/products_instock_shipping_edit_online.php?action=finance_auto_order&products_instock_id='.$instockOrder->products_instock_id;
                        // 更新timed_push_status
                        $orderRepository->updateOrderTimePushStatus($orderNumber);
                    } else {
                        $urls[] = config('app.service_erp_url') . '/products_instock_shipping_edit_unline.php?action=finance_auto_order&products_instock_id='.$instockOrder->products_instock_id;
                    }
                }
                $vouchers[] = new VoucherResource($voucher);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new VoucherException(__('finance::voucher.createVoucherFailed'),FoundationResponse::HTTP_BAD_REQUEST, $exception);
        }
        return $this->successWithData(compact('vouchers', 'urls'));
    }

    /**
     * @param  VoucherListRequest  $request
     * @param  VoucherRepository  $repository
     * @param  AdminService  $service
     * @param  OrderCustomerCompanyService  $companyService
     * @param  CustomerRepository  $customerRepository
     * @param  CustomerCompanyRepository  $companyRepository
     * @return \Illuminate\Http\JsonResponse|VoucherListCollectionResource
     */
    public function index(
        VoucherListRequest $request,
        VoucherRepository $repository,
        AdminService $service,OrderCustomerCompanyService $companyService,
        CustomerRepository $customerRepository,
        CustomerCompanyRepository $companyRepository,
        InstockShippingRepository $instockShippingRepository,
        CompanyRepository $orderCompanyRepository,
        PaymentMethodService $paymentMethodService
    )
    {
        $filter = $request->input('filter');
        $user = Auth::user();
        if ($user->hasPermissionTo('finance.voucher.vouchers.all')){
            $admins = [];
            $type = 1;
        } else if ($user->hasPermissionTo('finance.voucher.vouchers.group')){
            $admins = $service->getGroupAdmins($user)->pluck('uuid')->all();
            $type = 2;
        } else {
            $type = 3;
            $admins = $user->uuid;
        }

        $sort = $request->input('sort') ?? [];
        $sort = $sort['created_at'] ?? "DESC";

        if($filter && isset($filter['key']) && $filter['key']){ // 走es查询逻辑
            $key = $filter['key'];
            $lists = $repository->getTypeIndexByES($type, $request->input('limit'), $key, $admins, $sort);
        } else {
            $repository->pushCriteria(new ListRequestCriteria($request));
            $lists = $repository->getTypeIndex($type, $request->input('limit'), $admins, $sort);
        }
        return new VoucherListCollectionResource($lists, $companyService,  $customerRepository,  $companyRepository, $instockShippingRepository, $orderCompanyRepository, $paymentMethodService);
    }

    /**
     * @param  ApiRevokeRequest  $request
     * @param  VoucherRepository  $repository
     * @param  AdminService  $adminService
     * @return \Illuminate\Http\JsonResponse
     * @throws VoucherException
     * @throws \Modules\Permission\Exceptions\UnauthorizedException
     */
    public function apiRevoke(ApiRevokeRequest $request, ReceiptsVouchersRepository $repository, AdminService $adminService)
    {
        $admin = $adminService->getAdminInfoById($request->input('admin_id'));
        $this->checkPermission($admin, 'finance.voucher.vouchers.action');
        $details = $repository->getReceiptsVouchersByOrderNumber($request->input('order_number'));
        if($details->isEmpty()) {
            throw new VoucherException(__('finance::voucher.orderNotFound'));
        }
        DB::beginTransaction();
        try {
            foreach ($details as $detail) {
                $detail->receipt->decrement('used', $detail->receipt_use);
                $repository->revokeReceiptsToVouchers($detail->receiptToVoucher, $detail->receipt_use, $detail->voucher_use);
                $detail->voucher->decrement('used', $detail->voucher_use);
                $detail->delete();
            }
            DB::commit();
        } catch (\Exception $exception){
            DB::rollBack();
            throw new VoucherException(__('finance::voucher.revokeFailed'));
        }
        return $this->successWithMessage(__('finance::voucher.revokeSuccess'));
    }

    /**
     * @param  ApiSplitRequest  $request
     * @param  VoucherRepository  $repository
     * @param  AdminService  $adminService
     * @param  InstockShippingRepository  $instockShippingRepository
     * @param  ReceiptRepository  $receiptRepository
     * @param  ReceiptsVouchersRepository  $receiptsVouchersRepository
     * @return \Illuminate\Http\JsonResponse
     * @throws VoucherException
     * @throws \Modules\Permission\Exceptions\UnauthorizedException
     */
    public function apiSplit(
        ApiSplitRequest $request,
        VoucherRepository $repository,
        AdminService $adminService,
        InstockShippingRepository $instockShippingRepository,
        ReceiptRepository $receiptRepository,
        ReceiptsVouchersRepository $receiptsVouchersRepository,
        PaymentReceiptsVouchersDetailRepository $paymentReceiptsVouchersDetailRepository
    )
    {
        $admin = $adminService->getAdminInfoById($request->input('admin_id'));
        $this->checkPermission($admin, 'finance.voucher.vouchers.action');

        $orderInfos = $request->input('order_info');

        if (isset($orderInfos[0]['parent_id'])) {
            $this->splitOriginDetail($request, $paymentReceiptsVouchersDetailRepository, $instockShippingRepository, $repository, $receiptRepository, $receiptsVouchersRepository);
        } else {
            $this->splitVoucher($request, $repository, $instockShippingRepository, $receiptRepository, $receiptsVouchersRepository);
        }

        return $this->successWithMessage(__('finance::voucher.splitSuccess'));
    }


    /**
     * @param  ApiVoucherStoreRequest  $request
     * @param  VoucherRepository  $repository
     * @param  AdminService  $adminService
     * @return \Illuminate\Http\JsonResponse
     * @throws \Modules\Permission\Exceptions\UnauthorizedException
     */
    public function apiVouchersStore(
        ApiVoucherStoreRequest $request,
        VoucherRepository $repository,
        AdminService $adminService
    )
    {
        $admin = $adminService->getAdminInfoById($request->input('admin_id'));
        $this->checkPermission($admin, 'finance.voucher.vouchers.action');

        $data = [
            'order_number'            => $request->input('order_number'),
            'currency'                => $request->input('currency'),
            'usable'                  => $request->input('order_price'),
            'used'                    => $request->input('order_price'),
            'type'                    => $request->input('type'),
            'remark'                  => $request->input('remark'),
            'customer_company_number' => $request->input('customer_company_number'),
            'customer_company_name'   => $request->input('customer_company_name'),
            'customer_number'         => $request->input('customer_number')??"",
            'creator_uuid'            => $admin->uuid,
            'creator_name'            => $admin->name,
            'uuid'                    => Str::uuid()->getHex()->toString(),
            'number'                  => Number::create('CW')->get(),
        ];
        $file = $request->file ?? [];
        $voucher = $repository->storeVoucher($data);
        $repository->addMedia($voucher, $file);
        $voucher = new VoucherResource($voucher);
        return $this->successWithData(compact('voucher'));
    }

    /**
     * 判断是否为帐期单
     * @param  InstockShippingRepository  $instockShippingRepository
     * @param  string  $orderNumber
     * @param  PaymentMethodRepository  $paymentMethodRepository
     * @return bool
     */
    protected function isAccountPeriod(InstockShippingRepository $instockShippingRepository, string $orderNumber)
    {
        $order = $instockShippingRepository->getOrderByOrderNumber($orderNumber);
        if ($order->isEmpty()){
            return false;
        } else {
            $order = $order->first();
            return in_array($order->order_payment, $this->accountPeriodMethod);
        }
    }


    /**
     * @param  OrderCustomerCompanyService  $service
     * @param  CustomerCompanyRepository  $customerCompanyRepository
     * @param  string  $orderNumber
     * @param  PaymentReceipt  $receipt
     * @return array
     * @throws VoucherException
     */
    protected function checkIsSeamCompany(
        OrderCustomerCompanyService $service,
        CustomerCompanyRepository $customerCompanyRepository,
        string $orderNumber,
        PaymentReceipt $receipt
    )
    {
        $customerNumber = $service->getCustomerAndCompanyInfoByOrderNumber($orderNumber);

        $orderCustomerCompany = $customerCompanyRepository->getCompanyByCustomerNumber($customerNumber->customerNumber);

        $orderCustomerCompanyNumber = $orderCustomerCompany ? $orderCustomerCompany->company_number :"";

        if ($orderCustomerCompanyNumber != $receipt->customer_company_number) {
            throw new VoucherException(__('finance::voucher.DKAndOrderMustSeamCompany'));
        }

        return [
            'customer_company_number' => $orderCustomerCompanyNumber,
            'customer_company_name'   => $orderCustomerCompany->customerOfCompany->customers_company,
            'customer_number'         => $customerNumber->customerNumber,
        ];
    }


    /**
     * 帐期单生成对应的使用记录
     * @param  PaymentReceiptsVouchersDetailRepository  $repository
     * @param  ReceiptRepository  $receiptRepository
     * @param  InstockShippingRepository  $instockShippingRepository
     * @param  InvoiceService  $invoiceService
     * @param  array  $relates
     * @param $productsInstockId
     * @param $orderNumber
     * @param $user
     * @param  int  $type type != 1  帐期单
     */
    protected function accountPeriodSetDetail(
        PaymentReceiptsVouchersDetailRepository $repository,
        ReceiptRepository $receiptRepository,
        InstockShippingRepository $instockShippingRepository,
        InvoiceService $invoiceService,
        array $relates,
        $productsInstockId,
        $orderNumber,
        $user,
        $type = 1
    )
    {
        $productsInstock = $instockShippingRepository->getOrderInfoByProductsInstockId($productsInstockId);
        foreach ($relates as $relate) {
            $relate['uuid'] = Str::uuid()->getHex()->toString();
            $relate['order_id'] = $productsInstockId;
            $relate['order_number'] = $orderNumber;
            $repository->store($relate);
        }
        // 清账
        if ($type != 1) {
            $invoiceService->invoiceReceiptClear($productsInstock, $user);
        }
    }


    /**
     * 多次拆分 拆分父级的 detail
     * @param  Request  $request
     * @param  Admin  $admin
     * @param  PaymentReceiptsVouchersDetailRepository  $repository
     * @param  InstockShippingRepository  $instockShippingRepository
     * @throws VoucherException
     */
    protected function splitOriginDetail(
        Request $request,
        PaymentReceiptsVouchersDetailRepository $paymentReceiptsVouchersDetailRepository,
        InstockShippingRepository $instockShippingRepository,
        VoucherRepository $repository,
        ReceiptRepository $receiptRepository,
        ReceiptsVouchersRepository $receiptsVouchersRepository
    )
    {
        $orderInfos = $request->input('order_info');
        $voucherNumber = $request->input('vouch_number');

        $orderInfosGroupByParent = collect($orderInfos)->groupBy('parent_id')->all();

        if(Arr::hasAny($orderInfosGroupByParent, ['', 0])) {
            throw new VoucherException(__('finance::voucher.mustAllHasParentId'));
        }
        DB::beginTransaction();
        try {
            foreach ($orderInfosGroupByParent as $key => $orderInfos) {
                $voucher = $paymentReceiptsVouchersDetailRepository->findDetailByNumberAndOrderId($voucherNumber, $key);
                if ($voucher->isEmpty()) {
                    throw new VoucherException(__('finance::voucher.NotFoundParentDetail'));
                }
                $originDetailCanUse = $voucher->sum('voucher_use');
                $orderNeedUse = 0;
                $orderInfoArray = $this->getOrderArray($orderInfos, $instockShippingRepository, $orderNeedUse);
                $orderNeedUse = round($orderNeedUse);
                if ($orderNeedUse > $originDetailCanUse) {
                    throw  new VoucherException(__('finance::voucher.parentDetailsPriceNotEnough'));
                }
                $DetailsData = $this->formatReceiptsToVoucherData($voucher);
                // 多对多分摊

                $details = $this->formatDetailsData($orderInfoArray, $DetailsData);
                foreach ($details as $detail) {
                    $detail['created_at'] = Carbon::now();
                    $paymentReceiptsVouchersDetailRepository->store($detail);
                }
                $voucher->map(function ($item){
                   $item->delete();
                });
                if ($orderNeedUse < $originDetailCanUse) {
                    // 现在的使用情况
                    $groupDetails = $this->groupDataByReceiptAndVoucherUuid($details);
                    // 原来的使用情况
                    $groupOriginDetails = $this->groupDataByReceiptAndVoucherUuid($DetailsData);
                    $this->eachRevoke($groupOriginDetails, $groupDetails, $receiptRepository, $receiptsVouchersRepository, $repository, null, 2);
                }

            }
            DB::commit();
        } catch (\Exception $exception){
            DB::rollBack();
            if($exception instanceof VoucherException) {
                throw $exception;
            } else {
                throw new VoucherException(__('finance::voucher.splitFailed'), FoundationResponse::HTTP_BAD_REQUEST, $exception);
            }
        }
    }

    /**
     * 第一次拆分，拆分 凭证的金额
     * @param  Request  $request
     * @param  VoucherRepository  $repository
     * @param  InstockShippingRepository  $instockShippingRepository
     * @param  ReceiptRepository  $receiptRepository
     * @param  ReceiptsVouchersRepository  $receiptsVouchersRepository
     * @throws VoucherException
     */
    protected function splitVoucher(
        Request $request,
        VoucherRepository $repository,
        InstockShippingRepository $instockShippingRepository,
        ReceiptRepository $receiptRepository,
        ReceiptsVouchersRepository $receiptsVouchersRepository
    ) {

        $orderInfos = $request->input('order_info');
        $voucher = $repository->getInfoByVoucherNumber($request->input('vouch_number'));
        if(is_null($voucher)) {
            throw new VoucherException(__('finance::voucher.voucherNotFound'));
        }

        $receiptsToVoucher = $voucher->receiptsToVoucher()->with('receipt')->get();

        $voucherCanUse = $voucher->usable; // 凭证可使用金额

        $orderAllNeedPrice = 0;
        DB::beginTransaction();
        try {
            $orderInfoArray = $this->getOrderArray($orderInfos, $instockShippingRepository ,$orderAllNeedPrice, $voucher);
            if($orderAllNeedPrice > $voucherCanUse) {
                throw  new VoucherException(__('finance::voucher.voucherPriceNotEnough'));
            }
            $receiptsToVoucherData = $this->formatReceiptsToVoucherData($receiptsToVoucher);
            // 多对多进行分摊
            $details = $this->formatDetailsData($orderInfoArray, $receiptsToVoucherData);
            // 插入数据
            foreach ($details as $detail) {
                $detail['created_at'] = Carbon::now();
                $repository->storeVoucherDetail($voucher, $detail);
            }

            if($orderAllNeedPrice < $voucherCanUse) { // 总金额小于可用金额 返还对应的使用金额
                $groupDetails = $this->groupDataByReceiptAndVoucherUuid($details);
                $groupVoucherToDetails = $this->groupDataByReceiptAndVoucherUuid($receiptsToVoucherData);
                // 返还金额
                $this->eachRevoke($groupVoucherToDetails, $groupDetails, $receiptRepository, $receiptsVouchersRepository, $repository, $receiptsToVoucher, 1);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            if($exception instanceof VoucherException) {
                throw $exception;
            } else {
                throw new VoucherException(__('finance::voucher.splitFailed'), FoundationResponse::HTTP_BAD_REQUEST, $exception);
            }
        }
    }


    protected function getOrderArray(
        $orderInfos,
        InstockShippingRepository $instockShippingRepository,
        &$orderAllNeedPrice,
        Model $model = null
    ) {
        foreach ($orderInfos as $orderInfo) {
            $order = $instockShippingRepository->getOrderInfoByProductsInstockId($orderInfo['product_instock_id']);
            if (is_null($order)) {
                throw new VoucherException(__('finance::voucher.orderNotFound'));
            }
            $orderPrice = $order->order_price * 100;
            $orderAllNeedPrice += $orderPrice;
            $orderInfoArray[] = [
                'order_number'     => $order->order_number ? $order->order_number : $order->order_invoice,
                'order_id'         => $orderInfo['product_instock_id'],
                'parent_id'        => $orderInfo['parent_id'] ?? 0,
                'origin_id'        => $orderInfo['origin_id'] ?? 0,
                'order_price'      => round($orderPrice), // 需要的金额
            ];
        }
        return $orderInfoArray;
    }

    /**
     * 格式化中间表 或者 多次拆分时格式化多对多表
     * @param $receiptsToVoucher
     * @return array
     */
    protected function formatReceiptsToVoucherData($receiptsToVoucher)
    {
        //
        foreach ($receiptsToVoucher as $item){
            $receiptsToVoucherData[] = [
                'receipt_uuid'       => $item->receipt_uuid,
                'receipt_number'     => $item->receipt_number,
                'receipt_currency'   => $item->receipt_currency,
                'receipt_use'        => $item->receipt_use,
                'voucher_uuid'       => $item->voucher_uuid,
                'release_use'        => $item->voucher_use, //
                'voucher_use'        => $item->voucher_use, //
                'receipt_created_at' => $item->receipt->created_at,
                'voucher_number'     => $item->voucher_number,
                'voucher_currency'   => $item->voucher_currency,
            ];
        }
        return $receiptsToVoucherData;
    }


    protected function formatDetailsData($orderInfoArray, $receiptsToVoucherData)
    {
        $details = [];
        foreach ($orderInfoArray as $item){
            $orderNeedPrice = $item['order_price']; // 每一单需要的金额
            $receiptsToVoucherData = collect($receiptsToVoucherData)
                ->map(function ($val)use($item,&$details,&$orderNeedPrice){
                    if ($orderNeedPrice == 0) {
                        return $val;
                    } else if ($val['release_use'] == 0) {
                        return $val;
                    } else if ($orderNeedPrice == $val['release_use']) { // 刚好相等
                        $detail = array_merge($val, $item);
                        $detail['uuid'] = Str::uuid()->getHex()->toString();
                        $detail['voucher_use'] = $orderNeedPrice;
                        if($detail['receipt_currency'] != $detail['voucher_currency']) {
                            $detail['receipt_use'] = Exchange::exchange($detail['receipt_created_at'], $detail['voucher_currency'], $detail['voucher_use'], $detail['receipt_currency']);
                        } else {
                            $detail['receipt_use'] = $detail['voucher_use'];
                        }
                        unset($detail['release_use'], $detail['order_price'], $detail['receipt_created_at']);
                        $details[] = $detail;
                        $val['release_use'] = 0;
                        $orderNeedPrice = 0;
                        return $val;
                    } else if ($orderNeedPrice > $val['release_use']) { // 订单要的金额大于DK 金额
                        $detail = array_merge($val, $item);
                        $detail['uuid'] = Str::uuid()->getHex()->toString();
                        $detail['voucher_use'] = $val['release_use'];
                        if($detail['receipt_currency'] != $detail['voucher_currency']) {
                            $detail['receipt_use'] = Exchange::exchange($detail['receipt_created_at'], $detail['voucher_currency'], $detail['voucher_use'], $detail['receipt_currency']);
                        } else {
                            $detail['receipt_use'] = $detail['voucher_use'];
                        }
                        unset($detail['release_use'], $detail['order_price'], $detail['receipt_created_at']);
                        $details[] = $detail;
                        $orderNeedPrice = $orderNeedPrice - $val['release_use'];
                        $val['release_use'] = 0;
                        return $val;
                    } else if ($orderNeedPrice < $val['release_use']) { // 订单金额小于 凭证对应的金额
                        $detail = array_merge($val, $item);
                        $detail['uuid'] = Str::uuid()->getHex()->toString();
                        $detail['voucher_use'] = round($orderNeedPrice);
                        if($detail['receipt_currency'] != $detail['voucher_currency']) {
                            $detail['receipt_use'] = Exchange::exchange($detail['receipt_created_at'], $detail['voucher_currency'], $detail['voucher_use'], $detail['receipt_currency']);
                        } else {
                            $detail['receipt_use'] = $detail['voucher_use'];
                        }
                        unset($detail['release_use'], $detail['order_price'], $detail['receipt_created_at']);
                        $details[] = $detail;
                        $val['release_use'] = $val['release_use'] - $orderNeedPrice;
                        $orderNeedPrice = 0;
                        return $val;
                    }
                })->all();
        }
        return $details;
    }

    /**
     * 按照 receipt_uuid-voucher_uuid 进行分组
     * @param $data
     * @return \Illuminate\Support\Collection
     */
    protected function groupDataByReceiptAndVoucherUuid($data)
    {
        $groupData = collect($data)->mapToGroups(function ($item){
            return [
                $item['receipt_uuid'] . '-' . $item['voucher_uuid'] => [
                    'receipt_use' => $item['receipt_use'],
                    'voucher_use' => $item['voucher_use'],
                ]
            ];
        })->map(function ($item){
            $item = collect($item);
            return [
                'receipt_use' => $item->sum(function ($val){
                    return $val['receipt_use'];
                }),
                'voucher_use' => $item->sum(function ($val){
                    return $val['voucher_use'];
                })
            ];
        });

        return $groupData;
    }


    /**
     * 循环返还 金额
     * @param $groupVoucherToDetails
     * @param $groupDetails
     * @param  ReceiptRepository  $receiptRepository
     * @param  ReceiptsVouchersRepository  $receiptsVouchersRepository
     * @param  null  $receiptsToVoucher
     */
    protected function eachRevoke($groupVoucherToDetails, $groupDetails, ReceiptRepository $receiptRepository, ReceiptsVouchersRepository $receiptsVouchersRepository, VoucherRepository $voucherRepository, $receiptsToVoucher = null, $type = 1)
    {
        foreach ($groupVoucherToDetails as $key => $val) {
            $uuids =  explode('-', $key);
            $receiptsUuid =$uuids[0];
            $voucherUuid = $uuids[1];
            if (!is_null($receiptsToVoucher)) {
                $receiptsToVoucherOne = $receiptsToVoucher
                    ->where('receipt_uuid', $receiptsUuid )
                    ->where('voucher_uuid', $voucherUuid)
                    ->first();
            } else {
                $receiptsToVoucherOne = $receiptsVouchersRepository->getReceiptsToVouchersByReceiptAndVoucherUuid($receiptsUuid, $voucherUuid);
            }

            $isRevoke = false;

            if(!isset($groupDetails[$key])) { // 完全没使用 全部退还
                $isRevoke = true;
                $revokeReceiptUse =  round($val['receipt_use']);
                $revokeVoucherUse = round($val['voucher_use']);
            } elseif ($val['receipt_use'] > $groupDetails[$key]['receipt_use']) { // 部分使用 退还未使用部分
                $isRevoke = true;
                $revokeReceiptUse = round($val['receipt_use'] - $groupDetails[$key]['receipt_use']);
                $revokeVoucherUse = round($val['voucher_use'] - $groupDetails[$key]['voucher_use']);

            }
            if ($isRevoke) {
                $receiptRepository->revokeUsed($receiptsUuid, round($revokeReceiptUse));
                $receiptsVouchersRepository->revokeReceiptsToVouchers($receiptsToVoucherOne, round($revokeReceiptUse), round($revokeVoucherUse));
                //if($type == 2) { // 再次拆分的 需要返还 voucher
                $voucherRepository->revokeUse($voucherUuid, $revokeVoucherUse);
                //}
            }
        }
    }


    /**
     * 1订单对1对到款
     * @param  Request  $request
     * @param  Admin  $admin
     * @param  Collection  $receipts
     * @param  ReceiptRepository  $receiptRepository
     * @param  OrderRepository  $orderRepository
     * @param  OrderPIRepository  $PIRepository
     * @param  OrderCustomerCompanyService  $service
     * @param  CustomerCompanyRepository  $customerCompanyRepository
     * @param  InstockShippingRepository  $instockShippingRepository
     * @param  OrderService  $orderService
     * @return array
     * @throws VoucherException
     * @throws \Modules\ERP\Exceptions\OrderException
     */
    protected function oneOrder2ManyReceipt(
        Request $request,
        Collection $receipts,
        OrderRepository $orderRepository,
        OrderPIRepository $PIRepository,
        OrderCustomerCompanyService $service,
        CustomerCompanyRepository $customerCompanyRepository,
        InstockShippingRepository $instockShippingRepository,
        OrderService $orderService
    )
    {
        $DKInfo = $request->input('DK_info');
        $orderInfo = $request->input('order_info');

        $customerCompanyNumber = $receipts->pluck('customer_company_number')->unique();

        if (count($customerCompanyNumber) > 1) {
            throw new VoucherException(__('finance::voucher.DKNotSeamCompanyNumber'));
        }

        $orderNumber = $orderInfo[0]['order_number'];
        $isOnline = $orderRepository::getOrderInfoByOrderNumber($orderNumber) ? true : false;


        $customerInfo = $this->checkIsSeamCompany($service, $customerCompanyRepository, $orderNumber, $receipts[0]);

        $isAccountPeriod = $this->isAccountPeriod($instockShippingRepository, $orderNumber);
        $order = $orderService->checkOrder($orderNumber);

        $this->checkIsRussianAlfa($receipts, $order->payment_method_id);

        $orderPrice = $order->order_price;

        if($orderPrice <= 0) {
            throw new VoucherException(__('finance::voucher.orderPriceNotRight'));
        }

        $orderCurrency = $orderInfo[0]['currency'];

        $canUsed = 0;

        foreach ($DKInfo as $dk) {
            $receipt = $receipts->firstWhere('number', $dk['number']);
            $dkUse = $dk['use'];
            if ($dkUse > $receipt->usable - $receipt->used) {
                throw new VoucherException(__('finance::receipt.orderUseMoreThanReceipt'));
            }

            $orderUse = $dk['order_use'];

            if ($dk['order_currency'] != $orderCurrency) {
                throw new VoucherException(__('finance::receipt.orderCurrencyError'));
            }

            if ($dk['currency'] != $receipt->currency) {
                throw new VoucherException(__('finance::receipt.DKCurrencyError'));
            }

            if ($orderCurrency != $receipt->currency) {
                $changeDK = Exchange::exchange($receipt->created_at, $orderCurrency, $orderUse, $receipt->currency);
                $changeOrder = Exchange::exchange($receipt->created_at, $receipt->currency, $dkUse ,$orderCurrency);
                $isOk = false;

                if($changeDK == $dkUse || $changeOrder == $orderUse) {
                    $isOk = true;
                }

                if (!$isOk) {
                    throw new VoucherException(__('finance::receipt.exchangeError'));
                }
            }

            $canUsed += $orderUse;
        }

        if ($canUsed != $orderPrice) {
            throw new VoucherException(__('finance::receipt.DKUseNoteEqualOrder'));
        }

        // 按照顺序剔除多余的 每个DK使用的金额
        $needReceipts = collect($DKInfo)->map(function ($item) use ($receipts, $orderPrice, $orderCurrency) {
            $useReceipt = $receipts->firstWhere('number', $item['number']);
            return [
                'receipt_uuid'     => $useReceipt->uuid,
                'receipt_number'   => $useReceipt->number,
                'receipt_currency' => $useReceipt->currency,
                'voucher_currency' => $orderCurrency,
                'voucher_use'      => $item['order_use'],
                'DKSelfUse'        => $item['use'], // 实际自己使用的金额（自己的币值）
                'DKOrderCanUse'    => $item['order_use'], // 转换成对应币制的金额
                'exchange'         => $item['exchange'],
            ];

        });

        //  生成一个 用款支出

        $number = Number::create('CW')->get();
        $voucherUuid = Str::uuid()->getHex()->toString();
        $voucherData = [
            'uuid'                    => $voucherUuid,
            'number'                  => $number,
            'currency'                => $orderCurrency,
            'usable'                  => $orderPrice,
            'used'                    => $orderPrice,
            'type'                    => 1,
            'order_number'            => $orderNumber,
            'customer_company_number' => $customerInfo['customer_company_number'],
            'customer_company_name'   => $customerInfo['customer_company_name'],
            'customer_number'         => $customerInfo['customer_number']
        ];

        // 创建对应的receipts_to_vouchers 数据
        $allRelate = [];

        $exchangeData = [];
        $needReceipts->map(function ($item) use($receipts,&$vouchers, &$allRelate, $number, &$exchangeData, $voucherUuid) {
            $relateData = [
                'voucher_uuid'     => $voucherUuid,
                'receipt_uuid'     => $item['receipt_uuid'],
                'receipt_number'   => $item['receipt_number'],
                'receipt_currency' => $item['receipt_currency'],
                'voucher_currency' => $item['voucher_currency'],
                'voucher_use'      => $item['voucher_use'],
                'receipt_use'      => $item['DKSelfUse'],
                'voucher_number'   => $number,
                'created_at'       => Carbon::now()
            ];
            $exchange = $item['exchange'];
            if ($exchange == 'true' && $item['DKCanUsed'] > $item['DKSelfUse']) { // 可用大于实际使用并勾选 汇兑损益
                $exchangeData[] = [
                    'uuid'     => $item['receipt_uuid'],
                    'exchange' => $item['DKSelfUse'] - $item['DKCanUsed'],
                ];
            }
            $allRelate[] = $relateData;
        });
        $data[] = [
            'isAccountPeriod'    => $isAccountPeriod,
            'voucherData'         => $voucherData,
            'relateData'          => $allRelate,
            'exchange'            => $exchangeData,
            'products_instock_id' => $order->products_instock_id,
            'origin_id'           => $order->origin_id,
            'isCustomerZone'      => (!isset($orderInfo[0]['customer_zone']) || $orderInfo[0]['customer_zone'] == 'false') ? false : true,
            'isOnline'            => $isOnline,
        ];
        return $data;

    }

    /**
     * 多订单对1到款
     * @param  Request  $request
     * @param  Collection  $receipts
     * @param  OrderRepository  $orderRepository
     * @param  OrderPIRepository  $PIRepository
     * @param  OrderCustomerCompanyService  $service
     * @param  CustomerCompanyRepository  $customerCompanyRepository
     * @param  InstockShippingRepository  $instockShippingRepository
     * @param  OrderService  $orderService
     * @return array
     * @throws VoucherException
     * @throws \Modules\ERP\Exceptions\OrderException
     */
    protected function manyOrder2OneReceipt(
        Request $request,
        Collection $receipts,
        OrderRepository $orderRepository,
        OrderPIRepository $PIRepository,
        OrderCustomerCompanyService $service,
        CustomerCompanyRepository $customerCompanyRepository,
        InstockShippingRepository $instockShippingRepository,
        OrderService $orderService
    )
    {
        $DKInfo = $request->input('DK_info');
        $orderInfo = $request->input('order_info');
        $receipt = $receipts->firstWhere('number', $DKInfo[0]['number']);

        $needDKPrice = 0;
        foreach ($orderInfo as $k => $item) {
            $isOnline = $orderRepository->getOrderInfoByOrderNumber($item['order_number']) ? true : false;

            $isAccountPeriod = $this->isAccountPeriod($instockShippingRepository, $item['order_number']);
            $order = $orderService->checkOrder($item['order_number']);

            $this->checkIsRussianAlfa($receipts, $order->payment_method_id);

            $customerInfo = $this->checkIsSeamCompany($service, $customerCompanyRepository, $item['order_number'], $receipt);

            $orderNeedDKPrice = $orderNeedPrice = $order->order_price;

            if($orderNeedDKPrice <= 0) {
                throw new VoucherException(__('finance::voucher.orderPriceNotRight'));
            }

            if ($item['currency'] != $receipt->currency) {
                $orderNeedDKPrice =Exchange::exchange($receipt->created_at, $item['currency'], $orderNeedPrice, $receipt->currency); // DK 自己实际使用的金额
            }
            $item['orderNeedDKPrice'] = $orderNeedDKPrice;
            $item['products_instock_id'] = $order->products_instock_id;
            $item['origin_id'] = $order->origin_id;
            $item['isAccountPeriod'] = $isAccountPeriod;
            $item['order_price'] = $orderNeedPrice;
            $orderInfo[$k] = $item;
            $needDKPrice += $orderNeedDKPrice; // 所需要的DK金额
        }

        $DKCanUseAmount = $receipt->usable - $receipt->used;
        if($needDKPrice > $DKCanUseAmount) {
            throw new VoucherException(__('finance::voucher.DKPriceNotEnough'));
        }

        $data = [];
        foreach ($orderInfo as $item) { // 循环生成对应的 用款凭证
            $number = Number::create('CW')->get();
            $voucherUuid = Str::uuid()->getHex()->toString();
            $voucherData = [
                'uuid' => $voucherUuid,
                'number'       => $number,
                'currency'     => $item['currency'],
                'usable'       => $item['order_price'],
                'used'         => $item['order_price'],
                'type'         => 1,
                'order_number' => $item['order_number'],
                'customer_company_number' => $customerInfo['customer_company_number'],
                'customer_company_name'   => $customerInfo['customer_company_name'],
                'customer_number'         => $customerInfo['customer_number']
            ];

            $relateData = [
                'voucher_uuid'     => $voucherUuid,
                'receipt_uuid'     => $receipt->uuid,
                'receipt_number'   => $receipt->number,
                'receipt_currency' => $receipt->currency,
                'voucher_currency' => $item['currency'],
                'voucher_use'      => $item['order_price'],
                'receipt_use'      => $item['orderNeedDKPrice'],
                'voucher_number'   => $number,
                'created_at'       => Carbon::now()
            ];
            $data[] = [
                'isAccountPeriod'     => $item['isAccountPeriod'],
                'voucherData'         => $voucherData,
                'relateData'          => [$relateData],
                'products_instock_id' => $item['products_instock_id'],
                'origin_id'           => $item['origin_id'],
                'isCustomerZone'      => (!isset($item['customer_zone']) || $item['customer_zone'] == 'false') ? false : true,
                'isOnline'            => $isOnline,
            ];
        }
        $exchange = [];
        if($needDKPrice < $DKCanUseAmount && $DKInfo[0]['exchange'] == 'true') { // todo
            $exchange[] = [
                'uuid'     => $receipt->uuid,
                'exchange' => $needDKPrice - $DKCanUseAmount
            ];
        }
        $data[0]['exchange'] = $exchange; // 只有一个 只需要抹平一次
        return $data;
    }

    /**
     * 1 对 1 数据
     * @param  Request  $request
     * @param  Collection  $receipts
     * @param  OrderRepository  $orderRepository
     * @param  OrderPIRepository  $PIRepository
     * @param  OrderCustomerCompanyService  $service
     * @param  CustomerCompanyRepository  $customerCompanyRepository
     * @param  InstockShippingRepository  $instockShippingRepository
     * @param  OrderService  $orderService
     * @return array
     * @throws VoucherException
     * @throws \Modules\ERP\Exceptions\OrderException
     */
    protected function oneOrder2OneReceipt(
        Request $request,
        Collection $receipts,
        OrderRepository $orderRepository,
        OrderPIRepository $PIRepository,
        OrderCustomerCompanyService $service,
        CustomerCompanyRepository $customerCompanyRepository,
        InstockShippingRepository $instockShippingRepository,
        OrderService $orderService
    )
    {
        $DKInfo = $request->input('DK_info');
        $orderInfo = $request->input('order_info');
        $receipt = $receipts->firstWhere('number', $DKInfo[0]['number']);

        $needDKPrice = 0;

        $orderNumber = $orderInfo[0]['order_number'];

        $isOnline = $orderRepository::getOrderInfoByOrderNumber($orderNumber) ? true : false;


        $isAccountPeriod = $this->isAccountPeriod($instockShippingRepository, $orderNumber);
        $order = $orderService->checkOrder($orderNumber);

        $this->checkIsRussianAlfa($receipts, $order->payment_method_id);

        $customerInfo = $this->checkIsSeamCompany($service, $customerCompanyRepository, $orderNumber, $receipt);

        $orderNeedDKPrice = $orderNeedPrice = $order->order_price;

        if($orderNeedDKPrice <= 0) {
            throw new VoucherException(__('finance::voucher.orderPriceNotRight'));
        }

        if ($orderInfo[0]['currency'] != $receipt->currency) {
            $orderNeedDKPrice =Exchange::exchange($receipt->created_at, $orderInfo[0]['currency'], $orderNeedPrice, $receipt->currency); // DK 自己实际使用的金额
        }
        $DKCanUseAmount = $receipt->usable - $receipt->used;
        if($orderNeedDKPrice > $DKCanUseAmount) {
            throw new VoucherException(__('finance::voucher.DKPriceNotEnough'));
        }
        $number = Number::create('CW')->get();
        $voucherUuid = Str::uuid()->getHex()->toString();
        $voucherData = [
            'uuid'         => $voucherUuid,
            'number'       => $number,
            'currency'     => $orderInfo[0]['currency'],
            'usable'       => $order->order_price,
            'used'         => $order->order_price,
            'type'         => 1,
            'order_number' => $orderInfo[0]['order_number'],
            'customer_company_number' => $customerInfo['customer_company_number'],
            'customer_company_name'   => $customerInfo['customer_company_name'],
            'customer_number'         => $customerInfo['customer_number'],
        ];

        $relateData = [
            'voucher_uuid'     => $voucherUuid,
            'receipt_uuid'     => $receipt->uuid,
            'receipt_number'   => $receipt->number,
            'receipt_currency' => $receipt->currency,
            'voucher_currency' => $orderInfo[0]['currency'],
            'voucher_use'      => $orderInfo[0]['order_price'],
            'receipt_use'      => $orderNeedDKPrice,
            'voucher_number'   => $number,
            'created_at'       => Carbon::now()
        ];

        $exchange = [];
        if($needDKPrice < $DKCanUseAmount && $DKInfo[0]['exchange'] == 'true') { // todo
            $exchange[] = [
                'uuid'     => $receipt->uuid  ,
                'exchange' => $needDKPrice - $DKCanUseAmount
            ];
        }
        $data[] = [
            'isAccountPeriod'     => $isAccountPeriod,
            'voucherData'         => $voucherData,
            'relateData'          => [$relateData],
            'exchange'            => $exchange,
            'products_instock_id' => $order->products_instock_id,
            'origin_id'           => $order->origin_id,
            'isCustomerZone'      =>  (!isset($orderInfo[0]['customer_zone']) || $orderInfo[0]['customer_zone'] == 'false') ? false : true,
            'isOnline'            => $isOnline
        ];
        return $data;
    }

    /**
     * 队列下载 数据
     * @param  VoucherListDownloadRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function voucherListDownload(VoucherListDownloadRequest $request)
    {
        $email = Auth::user()->email;

        if(!$email) {
            return $this->failedWithMessage(__('finance::common.hasNotSetEmail'));
        }

        dispatch(new DownloadVoucherList($request->all()));
        return $this->successWithMessage(__('finance::receipt.downloadInQueue'));
    }


    /**
     * @param  Collection  $receipts
     * @param $orderPayment
     * @return bool
     * @throws VoucherException
     */
    protected function checkIsRussianAlfa(Collection $receipts, $orderPayment)
    {
        $receiptsPayment = $receipts->pluck('payment_method_id')->unique()->all();

        $receiptsPayment[] = $orderPayment;

        $resPayment =  array_unique($receiptsPayment);

        if(in_array(42, $resPayment) && count($resPayment) > 1) {
            throw new VoucherException(__("finance::voucher.russianPaymentOnlyUsedRussian"));
        }
        return true;
    }
}



