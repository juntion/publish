<?php


namespace Modules\Finance\Http\Resources\Receipt;


use Modules\Base\Http\Resources\Json\Resource;
use Modules\ERP\Contracts\InstockShippingRepository;

class DetailsResource extends Resource
{
    public static $wrap = 'details';

    public function toArray($request)
    {

        $orderId = $this->order_id;

        $shipping = app()->make(InstockShippingRepository::class)->getOrderInfoByProductsInstockId($orderId);

        if($shipping) {
            $voucher_number = $shipping->orders_num;
            $order_number = $shipping->order_number ? $shipping->order_number : $shipping->order_invoice;
        } else {
            $voucher_number = $order_number = "";
        }

        return [
            "voucher_number"   => $voucher_number ? $voucher_number : $this->voucher_number,
            "voucher_currency" => $this->voucher_currency,
            "voucher_use"      => $this->voucher_use,
            "receipt_number"   => $this->receipt_number,
            "receipt_currency" => $this->receipt_currency,
            "receipt_use"      => $this->receipt_use,

            "order_number"     => $order_number ? $order_number :$this->order_number,

            "created_at"       => $this->getZoneDatetime($this->created_at),
        ];
    }
}
