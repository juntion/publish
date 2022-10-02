<?php


namespace App\Models;

use App\Models\BaseModel;

class ManageCustomerPosition extends BaseModel
{
    protected $table = "manage_customer_position";
    public $timestamps = false;
    protected $primaryKey = "position_id";
}
