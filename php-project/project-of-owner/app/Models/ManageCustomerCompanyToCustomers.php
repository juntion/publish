<?php


namespace App\Models;

use App\Models\BaseModel;

class ManageCustomerCompanyToCustomers extends BaseModel
{
    protected $table = "manage_customer_company_to_customers";
    protected $primaryKey = 'id';
    public $timestamps = false;
}
