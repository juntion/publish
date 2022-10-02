<?php


namespace App\Models;

class OrderSplitTotal extends BaseModel
{
    protected $table = 'orders_split_total';
    protected $primaryKey = 'orders_total_id';

    public function belongOrders()
    {
        return $this->belongsTo('App\Models\OrderSplit', 'orders_id', 'orders_id');
    }
}
