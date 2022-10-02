<?php
namespace App\Models;

class OrderProduct extends BaseModel
{
    protected $table = 'orders_products';
    protected $primaryKey = 'orders_products_id';

    public function orders()
    {
        return $this->belongsTo('App\Models\Order', 'orders_id', 'orders_id');
    }

    public function ordersProductsAttributes()
    {
        return $this->hasMany('App\Models\OrderProductAttribute', 'orders_products_id', 'orders_products_id');
    }

    public function ordersProductsLength()
    {
        return $this->hasOne('App\Models\OrderProductLength', 'orders_products_id', 'orders_products_id');
    }

    public function products()
    {
        return $this->hasOne('App\Models\Product', 'products_id', 'products_id');
    }

    public function review()
    {
        return $this->hasOne('App\Models\Review', "orders_products_id", "orders_products_id");
    }
}
