<?php

namespace App\Models;

class Categories extends BaseModel
{
    protected $table = "categories";
    protected $primaryKey = "categories_id";
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
    }
}
