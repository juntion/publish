<?php

namespace Modules\ERP\Contracts;


interface OrderTotalRepository
{
    /**
     * 根据线上订单编号获取订单金额信息
     */
    public static function getOrderPriceByOrderId($orderId);
}