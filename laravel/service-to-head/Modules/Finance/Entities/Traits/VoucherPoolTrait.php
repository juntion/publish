<?php


namespace Modules\Finance\Entities\Traits;


use Modules\Finance\Entities\PaymentReceiptsVouchersDetail;

trait VoucherPoolTrait
{
    private $voucherPool = [];

    public function getVoucherNumberByOrderId($orderId)
    {
        $voucher = $this->getAdminByUuid($orderId);
        return $voucher ? $voucher->voucher_number : "";
    }

    public function getAdminByUuid($orderId)
    {
        if (!array_key_exists($orderId, $this->voucherPool)) {
            $this->voucherPool[$orderId] = PaymentReceiptsVouchersDetail::query()->where('order_id', $orderId)->first();
        }

        return $this->voucherPool[$orderId];
    }
}
