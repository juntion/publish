<?php

namespace Modules\ERP\Contracts;


interface ProductsInstockShippingSalesAfterRepository
{
    /**
     * 根据特定条件获取订单售后信息
     */
    public static function getSaleAfterInfo($where);
}