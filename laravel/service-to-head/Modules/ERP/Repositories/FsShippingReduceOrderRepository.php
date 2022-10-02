<?php


namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\FsShippingReduceOrderRepository as ContractsFsShippingReduceOrderRepository;
use Modules\ERP\Entities\FsShippingReduceOrders;


class FsShippingReduceOrderRepository implements ContractsFsShippingReduceOrderRepository
{
    public static function getReduceInfoByShippingId($productInstockId)
    {
        return FsShippingReduceOrders::where('products_instock_id', $productInstockId)->orderBy('id', 'desc')->get();
    }
}