<?php

namespace Modules\ERP\Entities;

class ProductsInstockShippingSalesAfter extends Model
{
    protected $table = "products_instock_shipping_sales_after";

    protected $primaryKey = "return_id";

    public function export(): array
    {
        return [];
    }
}
