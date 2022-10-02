<?php

namespace Modules\ERP\Contracts;

interface OrderOffsetInfosRepository
{

    /**
     * 根据订单id数组，返回对应的红冲数据
     * @param array $ids
     * @return mixed
     */
    public function getOrderCreditRefund(array $ids);
    /**
     * 根据订单id数组，返回对应的红冲数据
     * @param array $ids
     * @return mixed
     */
    public function getOrderCreditAfter(array $ids);
    /**
     * 根据订单id数组，返回对应的折让数据
     * @param array $ids
     * @return mixed
     */
    public function getOrderConcession(array $ids);
}
