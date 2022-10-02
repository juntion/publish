<?php

namespace App\Models;

class CustomerInquiryProducts extends BaseModel
{
    protected $table = 'customer_inquiry_products';
    protected $primaryKey = 'id';


    public function customerInquiry()
    {
        return $this->belongsTo('App\Models\CustomerInquiry', 'inquiry_id', 'inquiry_id');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'products_id', 'products_id');
    }

    public function customerInquiryProductsAttributes()
    {
        return $this->hasMany('App\Models\CustomerInquiryProductsAttributes', 'inquiry_products_id', 'id');
    }

    public function customerInquiryProductsLength()
    {
        return $this->hasMany('App\Models\CustomerInquiryProductsLength', 'inquiry_products_id', 'id');
    }

    public function productDescription()
    {
        return $this->hasOne('App\Models\ProductDescription', 'products_id', 'products_id');
    }
}
