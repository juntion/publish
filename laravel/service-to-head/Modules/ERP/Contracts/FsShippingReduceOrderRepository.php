<?php

namespace Modules\ERP\Contracts;


interface FsShippingReduceOrderRepository
{
    /**
     * 根据订单流程ID获取订单冲减应收信息
     */
    public static function getReduceInfoByShippingId($productInstockId);
}