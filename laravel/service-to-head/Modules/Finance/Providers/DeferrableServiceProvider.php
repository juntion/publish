<?php

namespace Modules\Finance\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Modules\Finance\Contracts\InvoiceService;
use Modules\Finance\Contracts\ReceiptService;

class DeferrableServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public $bindings = [
    ];

    public $singletons = [
        ReceiptService::class => \Modules\Finance\Services\ReceiptService::class,
        InvoiceService::class => \Modules\Finance\Services\InvoiceService::class,
    ];

    public function provides()
    {
        return [
            ReceiptService::class,
            InvoiceService::class,
        ];
    }
}
