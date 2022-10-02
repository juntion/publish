<?php

namespace Modules\ERP\Contracts;

use Modules\ERP\Entities\ProductsInstockShipping;


interface ProductsInstockShippingInfoRepository
{
    /**
     * 根据订单信息获取产品信息
     */
    public static function getProductInfo(ProductsInstockShipping $instockShipping);
}