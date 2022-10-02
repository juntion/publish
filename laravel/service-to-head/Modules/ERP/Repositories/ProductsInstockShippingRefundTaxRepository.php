<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\ProductsInstockShippingRefundTaxRepository as ContractsProductsInstockShippingRefundTaxRepository;
use Modules\ERP\Entities\ProductsInstockShippingRefundTax;


class ProductsInstockShippingRefundTaxRepository implements ContractsProductsInstockShippingRefundTaxRepository
{
    public static function getOrderRefundInfo($productInstockId)
    {
        return ProductsInstockShippingRefundTax::where('products_instock_id', $productInstockId)->get();
    }
}