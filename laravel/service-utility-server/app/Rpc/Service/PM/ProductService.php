<?php

namespace App\Rpc\Service\PM;

use App\ProjectManage\Models\Product;
use App\Rpc\Traits\RpcTrait;

class ProductService
{
    use RpcTrait;

    /**
     * 获取产品数据
     * @param null $isOn
     * @return array
     */
    public function list($isOn = null)
    {
        $products = Product::query();
        if (!is_null($isOn)) {
            $products->where('status', $isOn);
        }
        $products = $products->get();
        return self::success($products->toArray());
    }
}
