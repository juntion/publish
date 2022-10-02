<?php

namespace App\Providers;

use App\Contracts\Rpc\BugRpcInterface;
use App\Contracts\Rpc\CompanyInterface;
use App\Contracts\Rpc\DepartmentRpcInterface;
use App\Contracts\Rpc\PermissionRpcInterface;
use App\Contracts\Rpc\UserRpcInterface;
use App\Rpc\Client\CompanyRpcClient;
use App\Rpc\Client\DepartmentRpcClient;
use App\Rpc\Client\PermissionRpcClient;
use App\Rpc\Client\PM\BugRpcClient;
use App\Rpc\Client\UserRpcClient;
use Illuminate\Support\ServiceProvider;

class ErpRpcProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRpcInterface::class, UserRpcClient::class);
        $this->app->bind(DepartmentRpcInterface::class, DepartmentRpcClient::class);
        $this->app->bind(PermissionRpcInterface::class, PermissionRpcClient::class);
        $this->app->bind(CompanyInterface::class, CompanyRpcClient::class);
        $this->app->bind(BugRpcInterface::class, BugRpcClient::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
