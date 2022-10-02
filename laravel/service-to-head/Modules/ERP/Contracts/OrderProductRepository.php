<?php

namespace Modules\ERP\Contracts;


interface OrderProductRepository
{
    /**
     * 根据订单ID获取产品信息 线上单
     */
    public static function getProductInfoByOrderID(array $ordersId);
}