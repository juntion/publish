<?php

namespace Modules\ERP\Http\Controllers\Order;

use Modules\ERP\Http\Controllers\Controller;
use Modules\ERP\Http\Requests\Order\OrderRequest;
use Modules\ERP\Http\Resources\Customer\CustomerResource;
use Modules\ERP\Contracts\OrderCustomerCompanyService;
use Modules\ERP\Contracts\CustomerCompanyRepository;
use Modules\ERP\Contracts\CustomerRepository;
use Modules\ERP\Service\OrderService;
use Modules\Share\Entities\Collection;
use Modules\ERP\Http\Resources\Order\OrderResource;

class OrderController extends Controller
{
    /**
     * 通过订单编号获取客户信息
     *
     * @param OrderRequest $request
     * @param OrderCustomerCompanyService $customerCompanyService
     * @param CustomerRepository $customerRepository
     * @param CustomerCompanyRepository $companyRepository
     * @return \Illuminate\Http\JsonResponse|CustomerResource
     */
    public function getOrderInfo(OrderRequest $request, OrderCustomerCompanyService $customerCompanyService, CustomerRepository $customerRepository, CustomerCompanyRepository $companyRepository)
    {
        $orderNumber = $request->post('order_number');
        // 获取客户编号
        $orderInfo = $customerCompanyService->getCustomerAndCompanyInfoByOrderNumber($orderNumber);

        $customerNumber = $orderInfo->customerNumber;

        if (empty($customerNumber)) {
            return $this->failedWithMessage(__('erp::order.getCusNumFailed'));
        }

        // 获取客户信息
        $customer = (isset($orderInfo->Info) && !empty($orderInfo->Info)) ? $orderInfo->Info : $customerRepository->getCustomerByNumber($customerNumber);

        if (is_null($customer)) {
            return $this->failedWithMessage(__('erp::order.getCusInfoFailed'));
        }

        // 获取公司信息
        $company = $companyRepository->getCompanyByCustomerNumber($customerNumber);
        if (is_null($company)) {
            return $this->failedWithMessage(__('erp::order.getComNumFailed'));
        }

        $orderData = new Collection();
        $orderData->company = $company;
        $orderData->customer = $customer;

        return new CustomerResource($orderData);
    }

    /**
     * 录单支出信息获取
     *
     * @param OrderRequest $request
     * @param OrderService $orderService
     * @return \Illuminate\Http\JsonResponse|OrderResource|array
     */
    public function getOrderVouchInfo(OrderRequest $request, OrderService $orderService)
    {
        $orderNumber = $request->post('order_number');

        $orderInfo = $orderService->checkOrder($orderNumber);

        return new OrderResource($orderInfo);
    }
}