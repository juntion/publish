<?php

namespace Tests;

use App\Contracts\Rpc\DepartmentRpcInterface;
use App\Contracts\Rpc\PermissionRpcInterface;
use App\Contracts\Rpc\UserRpcInterface;
use App\Models\Permission\Role;
use App\Models\User;
use App\Support\RpcMock\DepartmentRpcMock;
use App\Support\RpcMock\PermissionRpcMock;
use App\Support\RpcMock\UserRpcMock;
use App\Traits\TestingTrait;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, TestingTrait, WithFaker;

    public $user;

    protected function setUp(): void
    {
        parent::setUp();
        if (file_exists(base_path('.env.testing'))) {
            $this->withoutMiddleware(ThrottleRequests::class);
            $this->init();
            $this->rpcMock();
            $this->setToken();
        }
    }

    protected function tearDown(): void
    {
        Cache::tags('testing')->flush();
        parent::tearDown();
    }

    // 测试数据初始化
    protected function init()
    {
        Artisan::call('config:clear');
        Artisan::call('migrate');

        if (!$this->user = User::first()) {
            Role::createSuperRole();
            $this->user = factory(User::class, 1)->create()->first();
        }
        Artisan::call('db:seed');
        $this->user->assignRole(Role::SUPER_ROLE_ID);

    }

    // 登录、授权
    protected function setToken(): void
    {
        Auth::guard()->login($this->user);

        Gate::before(function (User $user, $ability) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });
    }

    protected function rpcMock()
    {
        $mockClasses = [
            UserRpcInterface::class => UserRpcMock::class,
            DepartmentRpcInterface::class => DepartmentRpcMock::class,
            PermissionRpcInterface::class => PermissionRpcMock::class,
        ];

        foreach ($mockClasses as $class => $mockClass) {
            $this->app->bind($class, $mockClass);
        }
    }
}
