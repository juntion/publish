<?php

namespace App\Models;

class OrdersStatusHistory extends BaseModel
{
    protected $table = "orders_status_history";
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function statusName()
    {
        return $this->hasOne('App\Models\OrderStatus', 'orders_status_id', 'orders_status_id');
    }
}
