<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\InstockShippingRepository as ContractsInstockShippingRepository;
use Modules\ERP\Entities\ProductsInstockShipping;


class InstockShippingRepository implements ContractsInstockShippingRepository
{
    public static function getOrderInfoByOrderNumber($orderNumber)
    {
        return ProductsInstockShipping::where('order_number', $orderNumber)->orWhere('order_invoice', $orderNumber)->first();
    }

    public static function getOrderByOrderNumber($orderNumber)
    {
        return ProductsInstockShipping::where('order_number', $orderNumber)->orWhere('order_invoice', $orderNumber)->get();
    }

    public static function getShippingFieldInfo(ProductsInstockShipping $instockShipping)
    {
        return ProductsInstockShipping::with(['instockShippingField'])->find($instockShipping->products_instock_id);
    }

    public static function getOrderInfoByOrderID($orderId)
    {
        return ProductsInstockShipping::where('orders_id', $orderId)->get();
    }

    public function getOrderInfoByProductsInstockId($id)
    {
        return ProductsInstockShipping::query()->find($id);
    }

    public function createByModel(ProductsInstockShipping $instock){
        if ($instock->exists) return $instock;
        $instock->save();
        $instock->refresh();
        return $instock;
    }

    public function shippingUpdate(array $fields, array $updateFields){
        return ProductsInstockShipping::where($fields)->update($updateFields);
    }

    /**
     * @param $ordersNum
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getOrderInfoByOrdersNum($ordersNum)
    {
        return ProductsInstockShipping::query()
            ->where('orders_num', $ordersNum)
            ->orderBy('products_instock_id', 'ASC')
            ->first();
    }
}
