<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\CustomerRepository as ContractsCustomerRepository;
use Modules\ERP\Entities\Customer;
use Modules\ERP\Entities\CustomersOffline;

class CustomerRepository implements ContractsCustomerRepository
{
    public static function getCustomerByNumber($number)
    {
        if (substr($number, 0, 1) <= 5) {
            return Customer::where('customers_number_new', $number)->first();
        } else {
            return CustomersOffline::where('customers_number_new', $number)->first();
        }
    }

    public static function getCustomerOnByID($customerId)
    {
        return Customer::find($customerId);
    }

    public static function getCustomerOffByID($customerId)
    {
        return CustomersOffline::find($customerId);
    }

    public static function getCustomerOffByEmail($customerEmail)
    {
        return CustomersOffline::where('customers_email_address', $customerEmail)->first();
    }
}
