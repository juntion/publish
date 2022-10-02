<?php

namespace Modules\ERP\Contracts;

use Modules\ERP\Entities\ProductsInstockShipping;


interface InstockShippingRepository
{
    /**
     * 根据订单号在订单流程中获取订单信息
     */
    public static function getOrderInfoByOrderNumber($orderNumber);

    /**
     * 根据订单号在订单流程中获取订单的所有信息 拆单原单+子单
     */
    public static function getOrderByOrderNumber($orderNumber);

    /**
     * 根据订单信息获取流程附表所有信息
     */
    public static function getShippingFieldInfo(ProductsInstockShipping $instockShipping);

    /**
     * 根据线上订单ID获取订单流程信息
     */
    public static function getOrderInfoByOrderID($orderId);

    /**
     * 根据主键在订单流程中获取订单信息
     * @param $id
     * @return mixed
     */
    public function getOrderInfoByProductsInstockId($id);

    /**
     * 创建订单信息
     * @param ProductsInstockShipping $instock
     * @return mixed
     */
    public function createByModel(ProductsInstockShipping $instock);

    /**
     * shipping表数据修改
     * @param array $fields
     * @param array $updateFields
     * @return mixed
     */
    public function shippingUpdate(array $fields, array $updateFields);

    /**
     * @param $ordersNum
     * @return mixed
     */
    public function getOrderInfoByOrdersNum($ordersNum);
}
