<?php

namespace Modules\ERP\Entities;

class ProductsInstockShippingApplyUniqueNumber extends Model
{
    protected $table = "products_instock_shipping_unique_number";

    /**
     * @return array
     */
    public function export(): array
    {
        return [];
    }

    public function shippingApply()
    {
        return $this->hasOne(ProductsInstockShippingApply::class, 'id', 'related_id');
    }
}

