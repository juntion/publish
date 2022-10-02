<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2021-03-26
 * Time: 18:46
 */

namespace Modules\ERP\Contracts;

use Modules\ERP\Entities\PaymentRelateOrders;

interface PaymentRelateOrdersRepository
{
    /**
     * 插入ERP关联到款数据
     * @param PaymentRelateOrders $paymentRelateOrders
     * @return mixed
     */
    public function createByModel(PaymentRelateOrders $paymentRelateOrders);
}