<?php


namespace App\Models;

use App\Models\BaseModel;

class AdminToCustomer extends BaseModel
{
    protected $table = "admin_to_customers";
    protected $primaryKey = "admin_to_customers_id";
    public $timestamps = false;
}
