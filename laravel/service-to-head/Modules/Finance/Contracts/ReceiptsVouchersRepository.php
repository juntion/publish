<?php


namespace Modules\Finance\Contracts;


use Modules\Finance\Entities\PaymentReceiptsToVoucher;

interface ReceiptsVouchersRepository
{
    /**
     * 通过订单号获取使用详情
     * @param $orderNumber
     * @return mixed
     */
    public function getReceiptsVouchersByOrderNumber($orderNumber);

    /**
     * 多对多表返钱
     * @param  PaymentReceiptsToVoucher  $paymentReceiptsToVoucher
     * @param  int  $receiptUsed
     * @param  int  $voucherUsed
     * @return mixed
     */
    public function revokeReceiptsToVouchers(PaymentReceiptsToVoucher $paymentReceiptsToVoucher, int $receiptUsed, int $voucherUsed);


    /**
     * 通过 receipt_uuid, voucher_uuid 获取指定关联关系
     * @param  string  $receiptUuid
     * @param  string  $voucherUuid
     * @return mixed
     */
    public function getReceiptsToVouchersByReceiptAndVoucherUuid(string $receiptUuid, string $voucherUuid);
}
