<?php


namespace App\Models;

use App\Models\BaseModel;

class Admin extends BaseModel
{
    protected $table = "admin";
    protected $primaryKey = 'admin_id';
    public $timestamps = false;

    public function customer()
    {
        return $this->hasMany('AdminToCustomer', 'customers_id', 'customers_id');
    }
}
