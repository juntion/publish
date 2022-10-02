<?php
namespace App\Models;

class ProductInstockOrder extends BaseModel
{
    protected $table = 'products_instock_orders';
    protected $primaryKey = 'id';

    public $timestamps = false;
}
