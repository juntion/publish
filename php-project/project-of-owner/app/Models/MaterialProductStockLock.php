<?php

namespace App\Models;

use App\Models\BaseModel;

class MaterialProductStockLock extends BaseModel
{
    protected $table = "material_products_stock_lock";
    public $timestamps = false;
    protected $primaryKey = "lock_id";
}
