<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\ProductsInstockShippingRepository as ProductsInstockShippingMain;
use Modules\ERP\Entities\ProductsInstockShipping as ProductsInstockShippingModel;

class ProductsInstockShippingRepository implements ProductsInstockShippingMain
{
    /**
     * @param array $fields
     * @return mixed
     */
    public static function getProductsInstockShippingData(array $fields = [])
    {
        return ProductsInstockShippingModel::where($fields)->get();
    }

    public  function getProductsInstockShippingByOrderNumber(string $orderNumber)
    {
        return ProductsInstockShippingModel::query()->where('order_number', $orderNumber)->first();
    }
}
