<?php

namespace App\Models;

class ProductDescription extends BaseModel
{
    
    protected $table;
    protected $primaryKey = 'products_id, language_id';
    public function __construct($attribute = [])
    {
        parent::__construct($attribute);

        $this->table = self::trans("TABLE_PRODUCTS_DESCRIPTION");
    }
}
