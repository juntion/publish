<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\CustomerCompanyRepository as ContractsCustomerCompanyRepository;
use Modules\ERP\Entities\CompanyOfCustomer;

class CustomerCompanyRepository implements ContractsCustomerCompanyRepository
{
    public static function getCompanyByCustomerNumber($customerNumber)
    {
        return CompanyOfCustomer::with(['customerOfCompany'])->where('customers_number_new', $customerNumber)->orderBy('id', 'desc')->first();
    }
}
