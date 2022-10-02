<?php


namespace App\Models;

class CustomersOffline extends BaseModel
{
    protected $primaryKey = "customers_id";
    protected $table = "customers_offline";
    public $timestamps = false;
}
