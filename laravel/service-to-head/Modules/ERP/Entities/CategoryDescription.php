<?php

namespace Modules\ERP\Entities;

class CategoryDescription extends Model
{
    protected $table = 'categories_description';
    protected $primaryKey = 'categories_id';

    public function export(): array
    {
        return [];
    }
}
