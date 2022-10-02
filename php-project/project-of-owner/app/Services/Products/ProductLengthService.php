<?php

namespace App\Services\Products;

use App\Models\ProductLength;
use App\Services\BaseService;

class ProductLengthService extends BaseService
{
    private $lengthObj;

    public function __construct()
    {
        parent::__construct();

        $this->lengthObj = new ProductLength();
    }

    /**
     * 根据指定产品的指定长度查找product_lengths表中的记录ID
     * @param $products_id  产品ID
     * @param $length 带单位的长度 1m/km
     * @return mixed
     */
    public function getLengthIdByLength($products_id, $length)
    {
        $id = $this->lengthObj->where('product_id', $products_id)
            ->where('length', $length)
            ->pluck('id');
        return $id;
    }
}
