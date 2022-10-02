<?php

namespace App\Models;

class ProductClearanceType extends BaseModel
{
    protected $table = 'products_clearance_type';
    protected $primaryKey = 'clearance_id';

    public function ProductRow()
    {
        return $this->belongsToMany('App\Models\Product','products_clearance','clearance_id','products_id');
    }

    public function TypeProduct()
    {
        return $this->belongsToMany('App\Models\Product','products_clearance','clearance_id','products_id');
    }
}
