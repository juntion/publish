<?php

namespace Modules\ERP\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\ERP\Contracts\FinanceExchangeRateService;

class Exchange extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FinanceExchangeRateService::class;
    }
}
