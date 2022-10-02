<?php

namespace App\Providers;

use App\Support\WsGateway;
use GatewayWorker\Lib\Gateway;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // WebSocket 注册地址
        if (WsGateway::isEnabled()) {
            Gateway::$registerAddress = config('gateway-worker.default_register_address');
        }

        // 开启 sql 语句打印
        if (config('app.debug')) {
            \DB::enableQueryLog();
        }

        Builder::macro('search', function ($field, $value) {
            if (!Str::contains($value, '%')) {
                $value = '%' . $value . '%';
            }
            return $value ? $this->where($field, 'like', $value) : $this;
        });
    }
}
