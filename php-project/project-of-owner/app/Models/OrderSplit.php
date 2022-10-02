<?php


namespace App\Models;

class OrderSplit extends BaseModel
{
    protected $table = "orders_split";
    protected $primaryKey = "orders_id";
    public $timestamps = false;
    public $tableName = 'orders_split';

    public function orderSplitProducts()
    {
        return $this->hasMany('App\Models\OrderSplitProduct', 'orders_id', 'orders_id');
    }

    public function orderStatus()
    {
        return $this->hasOne('App\Models\OrderStatus', 'orders_status_id', 'orders_status');
    }

    public function orderFields()
    {
        return $this->hasOne('App\Models\OrderMiddleFields', 'orders_id', "orders_id");
    }

    public function orderSplitTotal()
    {
        return $this->hasMany('App\Models\OrderSplitTotal', 'orders_id', 'orders_id');
    }
}
