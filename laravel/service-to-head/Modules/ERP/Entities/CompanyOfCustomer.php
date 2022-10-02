<?php

namespace Modules\ERP\Entities;


class CompanyOfCustomer extends Model
{
    protected $table = "manage_customer_company_to_customers";

    protected $primaryKey = "id";

    public function export(): array
    {
        return [];
    }

    public function customerOfCompany()
    {
        return $this->hasOne(ManageCustomerCompany::class, 'company_number', 'company_number');
    }
}