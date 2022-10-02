<?php


namespace Modules\Finance\Http\Resources\Receipt;

use Illuminate\Support\Carbon;
use Modules\Base\Http\Resources\Json\ResourceCollection;

class ReceiptApplicationListResource extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                "apply_time" => $this->getZoneDatetime($this->getApplyTime($item)),
                "apply_name" => $item['apply_name'],
                "apply_number" => $item['apply_number'],
                "order_number" => $item['orders_num'],
                "receipt_number" => $item['DK_number'],
                "apply_currency" => $item['currencies_code'],
                "apply_amount" => $item['apply_amount'],
                "apply_status" => $item['status']
            ];
        })->all();
    }

    public function getApplyTime($item)
    {
        return Carbon::createFromTimeString($item['apply_time'], 'Asia/Shanghai')->tz(config('app.timezone'))->format('Y-m-d H:i:s');
    }

}
