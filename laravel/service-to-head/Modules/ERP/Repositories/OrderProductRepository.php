<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\OrderProductRepository as ContractsOrderProductRepository;
use Modules\ERP\Entities\OrderProducts;


class OrderProductRepository implements ContractsOrderProductRepository
{
    public static function getProductInfoByOrderID(array $ordersId)
    {
        return OrderProducts::whereIn('orders_id', $ordersId)->get();
    }
}