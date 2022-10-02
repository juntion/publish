<?php

namespace Modules\Permission\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Modules\Permission\Contracts\PermissionRepository as ContractsPermissionRepository;
use Modules\Permission\Repositories\PermissionRepository;

class RepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public $bindings = [
        ContractsPermissionRepository::class => PermissionRepository::class,
    ];

    public function provides()
    {
        return [
            ContractsPermissionRepository::class,
        ];
    }
}
