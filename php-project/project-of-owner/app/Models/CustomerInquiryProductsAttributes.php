<?php

namespace App\Models;

class CustomerInquiryProductsAttributes extends BaseModel
{
    protected $table = 'customer_inquiry_products_attributes';
    protected $primaryKey = 'id';

    public function productsOptions()
    {
        return $this->hasOne("App\Models\ProductOption", 'products_options_id', 'options_id');
    }
}
