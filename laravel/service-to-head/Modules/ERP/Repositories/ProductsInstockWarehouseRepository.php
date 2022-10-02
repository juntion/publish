<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\ProductsInstockWarehouseRepository as ProductsInstockWarehouseMain;
use Modules\ERP\Entities\ProductsInstockWarehouse;

class ProductsInstockWarehouseRepository implements ProductsInstockWarehouseMain
{

    /**
     * @param int $id
     * @return mixed
     */
    public function getWarehouseInfoById(int $id)
    {
        return ProductsInstockWarehouse::where('id', $id)->first();
    }

    /**
     * @param array $id
     * @return mixed
     */
    public function getWarehouseInfoByIdIn(array $id)
    {
        return ProductsInstockWarehouse::whereIn('id', $id)->get();
    }
}
