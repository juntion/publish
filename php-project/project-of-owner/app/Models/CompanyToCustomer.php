<?php

namespace App\Models;

class CompanyToCustomer extends BaseModel
{
    protected $table = 'manage_customer_company_to_customers';
    protected $primaryKey = 'id';

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customers_number_new', 'customers_number_new');
    }
}
