<?php
/**
 * Notes:
 * File name:AttrCustomColumnService
 * Create by: Jay.Li
 * Created on: 2020/8/28 0028 14:14
 */


namespace App\Services\Products;

use App\Models\AttributeCustomColumn;
use App\Models\ProductsCountLength;
use App\Services\BaseService;

class AttrCustomColumnService extends BaseService
{
    private $attrCustomColumn;

    private $productsCountLength;

    public function __construct()
    {
        parent::__construct();

        $this->attrCustomColumn = new AttributeCustomColumn();

        $this->productsCountLength = new ProductsCountLength();
    }

    public function findProductCountLength($where, $fields = ['*'])
    {
        $result = $this->productsCountLength->newQuery()->where($where)->first($fields);

        if (!empty($result)) {
            $result = $result->toArray();
        }

        return $result;
    }

    public function findInfo($where, $fields = ['*'])
    {
        $result = $this->attrCustomColumn->newQuery()
            ->where($where)
            ->first($fields);
        if (!empty($result)) {
            $result = $result->toArray();
        }

        return $result;
    }
}
