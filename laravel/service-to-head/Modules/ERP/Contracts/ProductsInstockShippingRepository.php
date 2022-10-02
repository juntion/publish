<?php

namespace Modules\ERP\Contracts;

interface ProductsInstockShippingRepository
{

    /**
     * @param array $fields
     * @return mixed
     */
    public static function getProductsInstockShippingData(array $fields = []);

    /**
     * 通过FS单号获取shipping表的数据
     * @param  string  $orderNumber
     * @return mixed
     */
    public function getProductsInstockShippingByOrderNumber(string $orderNumber);
}
