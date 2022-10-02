<?php


namespace Modules\Finance\Http\Resources\Receipt;

use Illuminate\Support\Carbon;
use Modules\Base\Http\Resources\Json\ResourceCollection;
use Modules\Finance\Entities\Traits\VoucherPoolTrait;

class ReceiptRefundListResource extends ResourceCollection
{
    use VoucherPoolTrait;

    public static $wrap = 'refunds';

    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                "refund_time"       =>  $this->getZoneDatetime($this->getRefundTime($item)),
                "apply_name"        =>  $item->user ? $item->user->admin_name : "",
                "refund_number"     =>  $item['refund_apply_number'],
                "receipt_number"    =>  $item['DK_number'],
                'voucher_number'    =>  $this->getVoucherNumberByOrderId($item['products_instock_id']), //凭证号,根据订单id查明细拆分表
                "order_number"      =>  $item['orders_number'],
                "refund_method"     =>  $item->paymentMethod ? $item->paymentMethod->payment_method : "",
                "refund_account"    =>  $item['account_number'],
                "refund_currency"   =>  $item->currency ? $item->currency->code : "",
                "apply_amount"      =>  round($item['apply_money'] * 100),
                "refund_amount"     =>  round($item['apply_money'] * 100),
                "refund_rate"       =>  $item['refund_rate'],
                "refund_status"     =>  $item['status'],
            ];
        })->all();
    }

    public function getRefundTime($item)
    {
        $refundTime = $item->finance_time > '0000-00-00 00:00:00' ? $item->finance_time : ($item->verify_time > '0000-00-00 00:00:00' ? $item->verify_time : $item->apply_time);
        return Carbon::createFromTimeString($refundTime, 'Asia/Shanghai')->tz(config('app.timezone'))->format('Y-m-d H:i:s');
    }

}
