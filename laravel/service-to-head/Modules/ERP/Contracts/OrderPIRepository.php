<?php

namespace Modules\ERP\Contracts;

use Modules\ERP\Entities\ManageCustomerInquiryPIInfo;


interface OrderPIRepository
{
    /**
     * 根据订单号获取订单信息 线下
     */
    public static function getOrderInfoByOrderNumber($orderNumber);

    /**
     * 根据订单号获取所有订单信息 针对订单号重复的异常情况
     */
    public static function getAllOrderByOrderNumber($orderNumber);

    /**
     * 获取PI订单产品信息
     */
    public static function getOrderProductInfo(ManageCustomerInquiryPIInfo $customerInquiryPIInfo);
}