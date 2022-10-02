<?php


namespace Modules\Finance\Http\Resources\Receipt;


use Modules\Base\Http\Resources\Json\Resource;

class ReceiptVouchersDetailsResource extends Resource
{
    public static $wrap = 'details';

    public function toArray($request)
    {
        return [
            'voucher_number'   => $this->voucher_number,
            'voucher_currency' => $this->voucher_currency,
            'voucher_use'      => $this->voucher_use,
            'receipt_number'   => $this->receipt_number,
            'receipt_currency' => $this->receipt_currency,
            'receipt_use'      => $this->receipt_use,
            'order_number'     => $this->order_number,
            'created_at'       => $this->created_at
        ];
    }
}
