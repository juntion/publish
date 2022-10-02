<?php

namespace Modules\Route\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Modules\Route\Contracts\RouteService;
use Modules\Route\Services\MenuRouteTreeService;

class DeferrableServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public $singletons  = [
        RouteService::class => MenuRouteTreeService::class,
    ];

    public function provides()
    {
        return [RouteService::class];
    }
}
