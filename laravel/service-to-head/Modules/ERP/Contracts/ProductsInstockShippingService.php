<?php

namespace Modules\ERP\Contracts;

use Modules\Finance\Entities\PaymentVoucher;

/**
 *  订单流程服务
 *
 * Interface ProductsInstockShippingService
 * @package Modules\ERP\Contracts
 */
interface ProductsInstockShippingService
{
    /**
     * 创建订单流程,生成一条订单信息,如果是账期结清 这不需要生成
     */
    public function createByVoucher(PaymentVoucher $paymentVoucher,array $data);
}
