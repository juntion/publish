<?php


namespace Modules\Finance\Entities\Traits;


trait CustomerTrait
{
    protected $customerPool = [];
    protected $customerInfoPool = [];

    protected function getCustomerFormPool($customerNumber, $orderInfo)
    {
        if(!array_key_exists($customerNumber, $this->customerPool)){
            // 获取客户信息
            $customer = (isset($orderInfo->Info) && !empty($orderInfo->Info)) ? $orderInfo->Info : $this->getCustomerInfoByPool($customerNumber);

            if (is_null($customer)) {
                $customer_number = "";
                $company_number = "";
                $customer_email = "";
                $company_name = "";
            } else {
                // 获取公司信息
                $company = $this->companyRepository->getCompanyByCustomerNumber($customerNumber);

                $customer_number = $customer->customers_number_new;
                $customer_email = $customer->customers_email_address;

                if (is_null($company)) {
                    $company_number = "";
                    $company_name = "";
                } else {
                    $company_number = $company->company_number;
                    $company_name = $company->customerOfCompany ? $company->customerOfCompany->customers_company : "";
                }
            }

            $customerData =  compact('customer_number', 'company_number', 'customer_email', 'company_name');
            $this->customerPool[$customerNumber] = $customerData;
        }
        return $this->customerPool[$customerNumber];

    }

    protected function getCustomerInfoByPool($customerNumber)
    {
        if(!array_key_exists($customerNumber, $this->customerPool)){
           $customer =  $this->customerRepository->getCustomerByNumber($customerNumber);
           $this->customerInfoPool[$customerNumber] = $customer;
        }
        return $this->customerInfoPool[$customerNumber];

    }



}
