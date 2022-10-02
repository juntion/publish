<?php
namespace Modules\ERP\Contracts;

use Modules\Finance\Entities\PaymentVoucher;
/**
 * 账期服务
 * Class RechnungInvoiceService
 * @package Modules\ERP\Contracts
 */
interface RechnungInvoiceService
{
    /**
     * 账期订单结清
     * @param PaymentVoucher $paymentVoucher
     * @param array $data
     * @return mixed
     */
    public function revokeRechnungInvoice(PaymentVoucher $paymentVoucher,array $data);

    /**
     * 判断合法单或者CW单是否为账期单
     * @param $instockArr
     * @return int
     */
    public function instocKIsAccount($instockArr);
}
