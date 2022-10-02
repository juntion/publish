<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Modules\Admin\Contracts\AdminService;

class DeferrableServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public $bindings = [
    ];

    public $singletons = [
        AdminService::class => \Modules\Admin\Services\AdminService::class,
    ];

    public function provides()
    {
        return [
            AdminService::class,
        ];
    }
}
