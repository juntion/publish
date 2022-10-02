<?php

namespace Modules\ERP\Tests\Feature;

use Modules\Base\Tests\AdminTestCase;
use Modules\ERP\Entities\Order;


class OrderTest extends AdminTestCase
{
    private static $baseOrderUrl = '/erp/order';

    public function testGetOrderInfo()
    {
        return $this->postJson(self::$baseOrderUrl . '/orders/customers/search',
            [
                'order_number' => Order::orderBy('orders_id', 'DESC')->first()->orders_number,
            ])->assertSuccessful()
            ->assertJsonStructure(['data' => ['customer']]);
    }

    public function testGetOrderVouchInfo()
    {
        return $this->postJson(self::$baseOrderUrl . '/orders/search',
            [
                'order_number' => Order::orderBy('orders_id', 'DESC')->first()->orders_number,
            ])->assertSuccessful()
            ->assertJsonStructure(['data' => ['order']]);
    }
}