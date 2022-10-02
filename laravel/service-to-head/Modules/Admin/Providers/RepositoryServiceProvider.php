<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Modules\Admin\Contracts\AdminRepository as ContractsAdminRepository;
use Modules\Admin\Repositories\AdminRepository;

class RepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public $bindings = [
        ContractsAdminRepository::class => AdminRepository::class,
    ];

    public function provides()
    {
        return [
            ContractsAdminRepository::class,
        ];
    }
}
