<?php

namespace Modules\ERP\Entities;

class ProductDescription extends Model
{
    protected $table = 'products_description';
    protected $primaryKey = 'products_id';

    public function export(): array
    {
        return [];
    }
}
