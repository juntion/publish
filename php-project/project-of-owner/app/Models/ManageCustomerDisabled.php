<?php


namespace App\Models;

use App\Models\BaseModel;

class ManageCustomerDisabled extends BaseModel
{
    protected $table = "manage_customer_customers_disabled";
    public $timestamps = false;
    protected $primaryKey = "id";
}
