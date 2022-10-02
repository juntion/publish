<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\OrderTotalRepository as ContractsOrderTotalRepository;
use Modules\ERP\Entities\OrderTotal;


class OrderTotalRepository implements ContractsOrderTotalRepository
{
    public static function getOrderPriceByOrderId($orderId)
    {
        return OrderTotal::where('orders_id', $orderId)->first();
    }
}