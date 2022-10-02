<?php

namespace Modules\ERP\Entities;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'categories_id';

    public function export(): array
    {
        return [];
    }

    public function description()
    {
        return $this->hasOne(CategoryDescription::class, 'categories_id', 'categories_id')
            ->where('language_id', 1);
    }
}
