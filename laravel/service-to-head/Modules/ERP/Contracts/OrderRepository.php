<?php

namespace Modules\ERP\Contracts;

use Modules\ERP\Entities\Order;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

interface OrderRepository extends RepositoryInterface,RepositoryCriteriaInterface
{
    /**
     * 根据订单号获取订单信息 线上
     */
    public static function getOrderInfoByOrderNumber($orderNumber);

    /**
     * 获取存款单数据
     * @return mixed
     */
    public function getOrdersDepositData();

    /**
     * 根据单号获取所有相关信息 针对订单号重复的异常情况
     */
    public static function getAllOrderByOrderNumber($orderNumber);

    /**
     * 根据主单ID查找所有子单信息
     */
    public static function getSonOrderByMainOrderID($mainOrderId);

    /**
     * 获取订单金额
     */
    public static function getOrderPrice(Order $order);

    /**
     * 更新存款单状态
     * @param int $orders_id
     * @param int $status
     */
    public static function storeDepositStatus(int $orders_id, int $status);

    /**
     * 根据订单ID获取订单信息
     * @param $orderId
     * @return mixed
     */
    public static function getOrderInfoByOrderId($orderId);

    /**
     * 根据订单号更新状态
     * @param $orderNumber
     * @return mixed
     */
    public function updateOrderTimePushStatus($orderNumber);
}
