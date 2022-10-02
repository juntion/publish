<?php

namespace Modules\ERP\Entities;


class ProductsInstockShippingInfo extends Model
{
    protected $table = "products_instock_shipping_info";

    protected $primaryKey = "products_shipping_info_id";

    public function export(): array
    {
        return [];
    }
}