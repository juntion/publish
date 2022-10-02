<?php

namespace App\Providers;

use App\Company\Models\Company;
use App\Company\Models\CompanyAddressInfo;
use App\Company\Models\CompanyPay;
use App\Company\Observers\CompanyAddressInfoObserver;
use App\Company\Observers\CompanyObserver;
use App\Company\Observers\CompanyPayObserver;
use Illuminate\Support\ServiceProvider;

class CompanyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Company::observe(CompanyObserver::class);
        CompanyAddressInfo::observe(CompanyAddressInfoObserver::class);
        CompanyPay::observe(CompanyPayObserver::class);
    }
}
