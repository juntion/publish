<?php

namespace App\Services\Orders;


use App\Models\Order as Model;
use App\Services\BaseService;

class OrdersCheckoutService extends BaseService
{
    protected $orderModel;

    /**
     * OrdersCheckoutService constructor.
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->registerModel();
    }

    protected function registerModel()
    {
        $this->orderModel = new Model();
    }

    /**
     * @Notes:获取最近一次下单信息
     *
     * @param array $field
     * @return array =
     * @author: aron
     * @Date: 2020-12-08
     * @Time: 12:14
     */
    public function getLatestOrder($field = [])
    {
        try {
            $field = !empty($field) ? $field : 'relate_address_id';
            $data = $this->orderModel->select($field)->where('customers_id', $this->customer_id)
                ->orderBy('orders_id', 'DESC')->first();
            if (empty($data)) {
                return [];
            }
            return !empty($data) ? $data->toArray() : [];
        } catch (\ Exception $e) {
            return [];
        }
    }
}
