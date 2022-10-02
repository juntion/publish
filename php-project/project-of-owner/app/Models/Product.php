<?php

namespace App\Models;

class Product extends BaseModel
{
    protected $table = 'products';
    protected $primaryKey = 'products_id';

    public function productDescription()
    {
        return $this->hasOne('App\Models\ProductDescription', 'products_id', 'products_id');
    }
}
