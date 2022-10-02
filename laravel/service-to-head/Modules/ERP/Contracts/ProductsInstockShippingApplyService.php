<?php

namespace Modules\ERP\Contracts;

use Modules\Finance\Entities\PaymentReceipt;

interface ProductsInstockShippingApplyService
{
    /**
     * 创建汇率浮动申请，
     *
     *  自动审核通过之后更新到款的汇率浮动值  $receiptRepository->updateFloat($receipt, $item['DKCanUsed'] - $item['DKSelfUse']);
     */
    public function createFloatApplyByReceipt(PaymentReceipt $paymentReceipt);
}
