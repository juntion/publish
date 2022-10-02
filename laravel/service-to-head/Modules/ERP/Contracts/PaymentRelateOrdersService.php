<?php
namespace Modules\ERP\Contracts;

use Modules\Admin\Entities\Admin;
use Modules\Finance\Entities\PaymentVoucher;

/**
 * ERP关联到款服务
 * Interface paymentRelateOrdersService
 * @package Modules\ERP\Contracts
 */
interface PaymentRelateOrdersService
{
    public function createByVoucher(PaymentVoucher $paymentVoucher, Admin $admin,array $data);
}
