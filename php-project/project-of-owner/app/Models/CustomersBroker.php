<?php

namespace App\Models;

class CustomersBroker extends BaseModel
{
    protected $table = "customers_broker";
    protected $primaryKey = "broker_id";
    protected $guarded = [];
    public $timestamps = false;
}
