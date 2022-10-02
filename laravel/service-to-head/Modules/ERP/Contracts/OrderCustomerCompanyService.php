<?php

namespace Modules\ERP\Contracts;


interface OrderCustomerCompanyService
{
    /**
     * 根据订单编号获取客户及公司信息
     */
    public function getCustomerAndCompanyInfoByOrderNumber($orderNumber);
}