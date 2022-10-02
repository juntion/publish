<?php

namespace Modules\ERP\Http\Controllers\Customer;

use Modules\ERP\Http\Controllers\Controller;
use Modules\ERP\Contracts\CustomerCompanyRepository;
use Modules\ERP\Contracts\CustomerRepository;
use Modules\ERP\Http\Requests\Customer\CustomerRequest;
use Modules\ERP\Http\Resources\Customer\CustomerResource;
use Modules\Share\Entities\Collection;

class CustomerController extends Controller
{
    /**
     * 根据客户编号获取客户信息
     *
     * @param CustomerRequest $request
     * @param CustomerRepository $customerRepository
     * @param CustomerCompanyRepository $customerRepository
     * @return \Illuminate\Http\JsonResponse|CustomerResource
     */
    public function getInfo(CustomerRequest $request, CustomerRepository $customerRepository, CustomerCompanyRepository $companyRepository)
    {
        $customerNumber = $request->post('customer_number');

        $customer = $customerRepository->getCustomerByNumber($customerNumber);
        if (is_null($customer)) {
            return $this->failedWithMessage(__('erp::customer.getCusNumFailed'));
        }

        $company = $companyRepository->getCompanyByCustomerNumber($customerNumber);
        if (is_null($company)) {
            return $this->failedWithMessage(__('erp::customer.getComNumFailed'));
        }

        $customerData = new Collection();
        $customerData->company = $company;
        $customerData->customer = $customer;

        return new CustomerResource($customerData);
    }
}
