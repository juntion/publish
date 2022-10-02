<?php

namespace Modules\ERP\Entities;


class FsShippingReduceOrders extends Model
{
    protected $table = "fs_shipping_reduce_orders";

    protected $primaryKey = "id";

    public function export(): array
    {
        return [];
    }
}