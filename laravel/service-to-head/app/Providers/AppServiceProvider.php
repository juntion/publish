<?php

namespace App\Providers;

//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // todo 兼容其他
//        DB::listen(function ($query) {
//            $bindings = $query->bindings;
//            $sql = str_replace('?', '%s', $query->sql);
//            $sql = sprintf($sql, ...$bindings);
//            Log::info($sql);
//        });
    }
}
