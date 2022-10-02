<?php

namespace Modules\ERP\Entities;


class ProductsInstockShippingRefundTax extends Model
{
    protected $table = "products_instock_shipping_refund_money_apply";

    protected $primaryKey = "id";

    public function export(): array
    {
        return [];
    }
}