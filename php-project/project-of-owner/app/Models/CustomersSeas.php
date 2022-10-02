<?php


namespace App\Models;

use App\Models\BaseModel;

class CustomersSeas extends BaseModel
{
    protected $table = "customers_seas";
    protected $primaryKey = 'id';
    public $timestamps = false;
}
