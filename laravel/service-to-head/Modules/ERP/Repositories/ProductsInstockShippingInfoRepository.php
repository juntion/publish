<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\ProductsInstockShippingInfoRepository as ContractsProductsInstockShippingInfoRepository;
use Modules\ERP\Entities\ProductsInstockShipping;
use Modules\ERP\Entities\ProductsInstockShippingInfo;


class ProductsInstockShippingInfoRepository implements ContractsProductsInstockShippingInfoRepository
{
    public static function getProductInfo(ProductsInstockShipping $instockShipping)
    {
        return ProductsInstockShippingInfo::where('products_instock_id', $instockShipping->products_instock_id)->first();
    }
}