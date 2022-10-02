<?php


namespace App\Models;

class ProductsInstockOrder extends BaseModel
{
    protected $table = 'products_instock_orders';
    protected $fillable = [
        'orders_id',
        'products_id',
        'qty',
        'instock_id',
        'date',
        'seattle_lock'
    ];
    public $timestamps = false;
}
