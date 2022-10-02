<?php


namespace Modules\ERP\Entities;


class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'products_id';

    public function export(): array
    {
        return [];
    }

    public function exportProductId(): array
    {
        return [
            'id' => $this->products_id
        ];
    }

    public function exportProductModel(): array
    {
        return [
            'model' => $this->products_model
        ];
    }

    public function description()
    {
        return $this->hasOne(ProductDescription::class, 'products_id', 'products_id')
            ->where('language_id', 1);
    }
}
