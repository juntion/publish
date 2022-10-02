<?php

namespace Modules\Route\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Modules\Route\Contracts\RouteRepository as ContractsRouteRepository;
use Modules\Route\Repositories\RouteRepository;

class RepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public $bindings = [
        ContractsRouteRepository::class => RouteRepository::class,
    ];

    public function provides()
    {
        return [
            ContractsRouteRepository::class,
        ];
    }
}
