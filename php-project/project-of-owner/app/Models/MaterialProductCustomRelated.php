<?php

namespace App\Models;

use App\Models\BaseModel;

class MaterialProductCustomRelated extends BaseModel
{
    protected $table = "material_products_custom_related";
    public $timestamps = false;
    protected $primaryKey = "related_id";
}
