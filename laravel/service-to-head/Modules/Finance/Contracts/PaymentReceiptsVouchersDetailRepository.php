<?php


namespace Modules\Finance\Contracts;


use Modules\Finance\Entities\PaymentReceiptsVouchersDetail;

interface PaymentReceiptsVouchersDetailRepository
{
    public function store(array $data);


    /**
     * 通过where条件返回结果集
     * @param string $fields
     * @param string $val
     * @return mixed
     */
    public function getDetailCollectionByWhere($fields = '', $val = '');

    /**
     * 通过voucher number 和 orderId字段找出对应的detail
     * @param  string  $voucherNumber
     * @param  int  $orderId
     * @return mixed
     */
    public function findDetailByNumberAndOrderId(string $voucherNumber, int $orderId);

    /**
     * @param  string  $receiptUuid
     * @param  string  $voucherNumber
     * @param  int  $orderId
     * @param  int  $receiptUse
     * @param  int  $voucherUse
     * @return mixed
     */
    public function updateUseByUuidNumberAndOrderNumber(string $receiptUuid, string $voucherNumber, string $orderNumber, int $receiptUse,int $voucherUse);

    /**
     * @param  PaymentReceiptsVouchersDetail  $paymentReceiptsVouchersDetail
     * @return mixed
     */
    public function creatByModel(PaymentReceiptsVouchersDetail $paymentReceiptsVouchersDetail);
}
