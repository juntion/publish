<?php


namespace App\Models;

class ProductsInstockShipping extends BaseModel
{
    protected $table = 'products_instock_shipping';

    protected $primaryKey = 'products_instock_id';

    public function order()
    {
        return $this->hasMany('App\Models\Order', 'orders_id', 'orders_id');
    }

    public function productsISApply()
    {
        return $this->hasMany('App\Models\ProuctInstockShippingApply', 'products_instock_id', 'products_instock_id');
    }
}
