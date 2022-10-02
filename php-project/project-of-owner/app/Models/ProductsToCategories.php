<?php

namespace App\Models;

class ProductsToCategories extends BaseModel
{
    protected $table = "products_to_categories";
    protected $primaryKey = "ptc_id";
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
    }
}
