<?php

namespace Modules\ERP\Contracts;


interface ProductsInstockShippingRefundTaxRepository
{
    /**
     * 获取订单退税信息
     */
    public static function getOrderRefundInfo($productInstockId);
}