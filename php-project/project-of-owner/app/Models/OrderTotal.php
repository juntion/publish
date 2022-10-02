<?php

namespace App\Models;

class OrderTotal extends BaseModel
{
    protected $table = 'orders_total';
    protected $primaryKey = 'orders_total_id';

    public function belongOrders()
    {
        return $this->belongsTo('App\Models\Order', 'orders_id', 'orders_id');
    }
}
