<?php

namespace App\Models;

class Order extends BaseModel
{
    protected $table = "orders";
    protected $primaryKey = "orders_id";
    public $timestamps = false;
    public $tableName = 'orders';

    public function orderProducts()
    {
        return $this->hasMany('App\Models\OrderProduct', 'orders_id', 'orders_id');
    }

    public function orderStatus()
    {
        return $this->hasOne('App\Models\OrderStatus', 'orders_status_id', 'orders_status');
    }

    public function orderTotal()
    {
        return $this->hasMany('App\Models\OrderTotal', 'orders_id', 'orders_id');
    }

    public function orderFields()
    {
        return $this->hasOne('App\Models\OrderMiddleFields', 'orders_id', "orders_id");
    }

    public function orderTotalTax()
    {
        return $this->hasMany('App\Models\OrderTotalTax', 'orders_id', 'orders_id');
    }

    public function orderProductsIS()
    {
        return $this->hasMany('App\Models\ProductsInstockShipping', 'orders_id', 'orders_id');
    }

    public function orderProductsISApply()
    {
        return $this->belongsToMany('App\Models\ProuctInstockShippingApply', 'products_instock_shipping', 'orders_id', 'products_instock_id');
    }

    public function orderStatusHistory()
    {
        return $this->hasMany('App\Models\OrdersStatusHistory', 'orders_id', 'orders_id');
    }
}
