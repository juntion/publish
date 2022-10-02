<?php

namespace App\Models;

class CustomerInquiryProductsLength extends BaseModel
{
    protected $table = 'customer_inquiry_products_length';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function productLength()
    {
        return $this->hasOne("App\Models\ProductLength", 'id', 'product_length_id');
    }

    public function productsCountLength()
    {
        return $this->hasOne("App\Models\ProductsCountLength", 'products_id', 'products_id');
    }
}
