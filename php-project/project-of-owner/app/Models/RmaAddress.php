<?php

namespace App\Models;

class RmaAddress extends BaseModel
{
    protected $table = "customers_service_address";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
    }
}
