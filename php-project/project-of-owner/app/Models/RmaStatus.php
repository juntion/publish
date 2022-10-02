<?php

namespace App\Models;

class RmaStatus extends BaseModel
{
    protected $table = "customers_service_status";
    protected $primaryKey = "id";

    public function __construct()
    {
        parent::__construct();
    }
}
