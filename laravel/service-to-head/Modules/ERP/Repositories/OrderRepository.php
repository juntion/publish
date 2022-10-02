<?php

namespace Modules\ERP\Repositories;

use Carbon\Carbon;
use Modules\ERP\Contracts\OrderRepository as OrderInterface;
use Modules\ERP\Entities\Order;
use Modules\ERP\Enums\Order\Status;
use Prettus\Repository\Eloquent\BaseRepository;

class OrderRepository extends BaseRepository implements OrderInterface
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return Order::class;
    }

    public static function getOrderInfoByOrderNumber($orderNumber)
    {
        return Order::where('orders_number', $orderNumber)->first();
    }

    /**
     * @inheritDoc
     */
    public function getOrdersDepositData()
    {
        return Order::with(['globalcollectPayment', 'statusHistory', 'orderToAdmin', 'paypal'])
            ->select('orders_id',
                'customers_id',
                'customers_name',
                'company_number',
                'customers_email_address',
                'date_purchased',
                'currency',
                'currency_value',
                'order_total',
                'payment_module_code',
                'orders_number',
                'currency',
                'delivery_country_id',
                'actual_currency',
                'timed_push_status')
            ->where([
                'is_instock' => 0,
                'is_offline' => 0,
                'is_test' => 0,
                ['payment_module_code', '!=', 'purchase'],
                ['main_order_id', '<', 2],
                ['date_purchased', '>=', Carbon::parse('-90 days', 'Asia/Shanghai')->toDateTimeString()],
                ['company_number', '!=', '']
            ])
            ->whereIn('orders_status', [Status::PAYMENT_RECEIVED, Status::PO_CONFIRMED])
            ->whereIn('timed_push_status', [0])
            ->where(function ($query) {
                $query->whereNotIn('payment_module_code', ["hsbc", "echeck"])
                    ->orWhere('actual_payment', '>', 0);
            })
            ->get();
    }

    /**
     * 更新存款单状态
     * @param int $orders_id
     * @param int $status
     * @return mixed
     */
    public static function storeDepositStatus(int $orders_id, int $status)
    {
        if (!empty($orders_id)) {
            $orders = Order::find($orders_id);
            $orders->timed_push_status = $status;
            return $orders->save();
        }
    }

    public static function getAllOrderByOrderNumber($orderNumber)
    {
        return Order::where('orders_number', $orderNumber)->get();
    }

    public static function getSonOrderByMainOrderID($mainOrderId)
    {
        return Order::where('main_order_id', $mainOrderId)->get();
    }

    public static function getOrderPrice(Order $order)
    {
        return Order::with(['prices'])
            ->where('orders_id', $order->orders_id)
            ->get();
    }

    public static function getOrderInfoByOrderId($orderId)
    {
        return Order::find($orderId);
    }

    public function updateOrderTimePushStatus($orderNumber)
    {
        Order::query()->where('orders_number', $orderNumber)->update([
            'timed_push_status' => 3
        ]);
    }
}
