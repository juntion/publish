<?php


namespace App\Models;

class OrderSplitProduct extends BaseModel
{
    protected $table = 'orders_split_products';
    protected $primaryKey = 'orders_products_id';

    public function ordersSplit()
    {
        return $this->belongsTo('App\Models\OrderSplit', 'orders_id', 'orders_id');
    }

    public function ordersProductsAttributes()
    {
        return $this->hasMany('App\Models\OrderSplitProductAttribute', 'orders_products_id', 'orders_products_id');
    }

    public function ordersProductsLength()
    {
        return $this->hasOne('App\Models\OrderSplitProductLength', 'orders_products_id', 'orders_products_id');
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
