<?php


namespace Modules\Finance\Entities;


use Modules\Base\Entities\Model;

class PaymentReceiptsToVoucher extends Model
{

    protected $table = 'f_payment_receipts_to_vouchers';

    protected $primaryKey = '';

    public $timestamps = false;

    protected $fillable = ['receipt_uuid', 'receipt_number', 'receipt_currency', 'receipt_use', 'voucher_uuid', 'voucher_number', 'voucher_currency', 'voucher_use', 'created_at', 'receipt_init', 'voucher_init'];

    public function receipt()
    {
        return $this->belongsTo(PaymentReceipt::class, 'receipt_uuid', 'uuid')->withTrashed();
    }

    public function voucher()
    {
        return $this->belongsTo(PaymentVoucher::class, 'voucher_uuid', 'uuid')->withTrashed();
    }
}
