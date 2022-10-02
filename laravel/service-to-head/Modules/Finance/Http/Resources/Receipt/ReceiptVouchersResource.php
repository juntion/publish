<?php


namespace Modules\Finance\Http\Resources\Receipt;


use Modules\Base\Http\Resources\Json\Resource;

class ReceiptVouchersResource extends Resource
{
    public static $wrap = 'vouchers';

    public function toArray($request)
    {
        return [
            "uuid"             => $this->voucher->uuid,
            "currency"         => $this->voucher->currency,
            "usable"           => $this->voucher->usable,
            "used"             => $this->voucher->used,
            "order_number"     => $this->voucher->order_number,
            "voucher_number"   => $this->voucher_number,
            "voucher_currency" => $this->voucher_currency,
            "voucher_use"      => $this->voucher_use,
            "voucher_init"     => $this->voucher_init,
            "receipt_number"   => $this->receipt_number,
            "receipt_currency" => $this->receipt_currency,
            "receipt_use"      => $this->receipt_use,
            "receipt_init"     => $this->receipt_init,
            "created_at"       => $this->getZoneDatetime($this->created_at),
        ];
    }
}
