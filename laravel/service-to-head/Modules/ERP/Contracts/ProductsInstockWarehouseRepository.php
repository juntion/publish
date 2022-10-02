<?php

namespace Modules\ERP\Contracts;

interface ProductsInstockWarehouseRepository
{

    /**
     * @param int $id
     * @return mixed
     */
    public function getWarehouseInfoById(int $id);

    /**
     * @param array $id
     * @return mixed
     */
    public function getWarehouseInfoByIdIn(array $id);
}
