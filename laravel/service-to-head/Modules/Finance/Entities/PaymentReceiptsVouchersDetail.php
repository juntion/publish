<?php


namespace Modules\Finance\Entities;


use Modules\Base\Entities\Model;

class PaymentReceiptsVouchersDetail extends Model
{
    protected $table = 'f_payment_receipts_vouchers_details';

    public $timestamps = false;

   protected $fillable
       = [
           'uuid', 'receipt_uuid', 'receipt_number', 'receipt_currency', 'receipt_use', 'voucher_uuid',
           'voucher_number', 'voucher_currency', 'voucher_use', 'order_number', 'order_id', 'parent_id', 'origin_id',
           'created_at'
       ];

    public function receipt()
    {
        return $this->hasOne(PaymentReceipt::class, 'uuid', 'receipt_uuid');
    }

    public function voucher()
    {
        return $this->hasOne(PaymentVoucher::class, 'uuid', 'voucher_uuid');
    }

    public function receiptToVoucher()
    {
        return $this->hasOne(PaymentReceiptsToVoucher::class, 'receipt_uuid', 'receipt_uuid')->where('voucher_uuid', $this->voucher_uuid);
    }
}
