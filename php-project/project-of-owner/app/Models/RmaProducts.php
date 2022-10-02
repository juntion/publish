<?php

namespace App\Models;

class RmaProducts extends BaseModel
{
    protected $table = "customers_service_products";
    protected $primaryKey = "id";

    public function __construct()
    {
        parent::__construct();
    }
}
