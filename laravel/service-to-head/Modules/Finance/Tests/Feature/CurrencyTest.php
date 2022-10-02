<?php

namespace Modules\Finance\Tests\Feature;

use Modules\Base\Tests\AdminTestCase;

class CurrencyTest extends AdminTestCase
{
    private static $currencyUri = '/finance/currency/rates';

    public function testGetRateByTime()
    {
        $this->postJson(self::$currencyUri . '/search', [
            'time' => now()
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['rates']]);
    }
}
