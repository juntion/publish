<?php

namespace App\Models;

class Rma extends BaseModel
{
    protected $table = "customers_service";
    protected $primaryKey = "customers_service_id";
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function products()
    {
        return $this->hasMany('App\Models\RmaProducts', 'service_id', 'customers_service_id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\RmaStatus', 'id', 'service_status');
    }

    public function address()
    {
        return $this->hasOne('App\Models\RmaAddress', 'customers_service_id', 'customers_service_id');
    }
}
