<?php

namespace Modules\Permission\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class DeferrableServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
    }

    public function provides()
    {
        return [];
    }
}
