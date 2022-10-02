<?php

namespace App\Models;

class OrdersFirstBillingData extends BaseModel
{
    protected $table = 'orders_first_billing_data';
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
    }
}
