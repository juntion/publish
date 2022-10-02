<?php

namespace Modules\ERP\Http\Resources\Customer;

use Modules\Base\Http\Resources\Json\Resource;

class CustomerResource extends Resource
{
    static public $wrap = "customer";

    public function toArray($request)
    {
        return [
            "company_number" => $this->company->company_number,
            "company_name" => $this->company->customerOfCompany->customers_company,
            "customer_number" => $this->customer->customers_number_new,
            "customer_name" => ($this->customer->customers_firstname) ? ($this->customer->customers_firstname . ' ' . $this->customer->customers_lastname) : $this->customer->customers_lastname,
            "manage_type" => $this->customer->manage_type,
            "manage_name" => ($this->customer->manage_type == '1') ? __('erp::customer.companyManage') : __('erp::customer.personalManage')
        ];
    }
}
