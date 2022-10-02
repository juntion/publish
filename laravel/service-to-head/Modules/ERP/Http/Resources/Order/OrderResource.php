<?php

namespace Modules\ERP\Http\Resources\Order;

use Modules\Base\Http\Resources\Json\Resource;

class OrderResource extends Resource
{
    static public $wrap = "order";

    public function toArray($request)
    {
        return [
            "order_number" => $this->order_number,
            "order_currency" => $this->order_currency,
            "order_price" => $this->order_price,
            "payment_method_id" => $this->payment_method_id,
            "is_online" => $this->is_online
        ];
    }
}