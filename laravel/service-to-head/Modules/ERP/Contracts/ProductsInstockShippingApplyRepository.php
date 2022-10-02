<?php

namespace Modules\ERP\Contracts;


interface ProductsInstockShippingApplyRepository
{
    /**
     * 根据不同条件获取申请汇总信息
     */
    public static function getShippingApplyInfo($where);
}