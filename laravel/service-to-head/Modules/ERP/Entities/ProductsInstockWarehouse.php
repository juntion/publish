<?php

namespace Modules\ERP\Entities;

class ProductsInstockWarehouse extends Model
{
    /**
     * @var string
     */
    protected $table = 'products_instock_warehouse';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @return array
     */
    public function export(): array
    {
        return [];
    }
}
