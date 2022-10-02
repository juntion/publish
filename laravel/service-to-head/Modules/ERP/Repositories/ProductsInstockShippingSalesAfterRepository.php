<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\ProductsInstockShippingSalesAfterRepository as ContractsProductsInstockShippingSalesAfterRepository;
use Modules\ERP\Entities\ProductsInstockShippingSalesAfter;


class ProductsInstockShippingSalesAfterRepository implements ContractsProductsInstockShippingSalesAfterRepository
{
    public static function getSaleAfterInfo($where)
    {
        return ProductsInstockShippingSalesAfter::where($where)->get();
    }
}