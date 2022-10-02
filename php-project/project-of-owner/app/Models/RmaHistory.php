<?php

namespace App\Models;

class RmaHistory extends BaseModel
{
    protected $table = "customers_service_history";
    protected $primaryKey = "customers_service_history_id";

    public function __construct()
    {
        parent::__construct();
    }
}
