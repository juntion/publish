<?php

namespace App\Models;

use App\Models\BaseModel;

class MaterialProductStock extends BaseModel
{
    protected $table = "material_products_stock";
    public $timestamps = false;
    protected $primaryKey = "stock_id";
}
