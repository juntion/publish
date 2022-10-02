<?php


namespace App\Services\ProductsInstocks;

use App\Models\ProductsInstockOrder;
use App\Services\BaseService;
use App\Models\ProductsInstock;

class ProductsInstockService extends BaseService
{
    protected $products_instock_model;
    protected $lockModel;

    public function __construct()
    {
        $this->products_instock_model = new ProductsInstock();
        $this->lockModel = new ProductsInstockOrder();
    }
}
