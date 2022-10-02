<?php

namespace Modules\ERP\Tests\Feature;

use Modules\Base\Tests\AdminTestCase;
use Modules\ERP\Entities\CustomersOffline;

class CustomerTest extends AdminTestCase
{
    private static $baseCustomerUrl = '/erp/customer/customers';

    public function testGetCompanyNum()
    {
        return $this->postJson(self::$baseCustomerUrl . '/search',
            [
                'customer_number' => CustomersOffline::orderBy('customers_id', 'DESC')->first()->customers_number_new,
            ])->assertSuccessful()
            ->assertJsonStructure(['data' => ['customer']]);
    }
}