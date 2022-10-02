<?php

namespace Modules\Base\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\Base\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapOssRoutes();
        $this->mapWebRoutes();
        $this->mapCompanyRoutes();
        $this->mapCountryRoutes();
        $this->mapCurrencyRoutes();
        $this->mapPaymentMethodRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('base')
            ->middleware(['api', 'auth:admin'])
            ->namespace($this->moduleNamespace)
            ->name('base.')
            ->group(module_path('Base', '/Routes/api.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapOssRoutes()
    {
        Route::prefix('base/oss')
            ->middleware(['api', 'auth:admin'])
            ->namespace($this->moduleNamespace)
            ->name('base.oss')
            ->group(module_path('Base', '/Routes/oss.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::prefix('base/web')
            ->middleware(['web'])
            ->namespace($this->moduleNamespace)
            ->name('base.web')
            ->group(module_path('Base', '/Routes/web.php'));
    }

    protected function mapCompanyRoutes()
    {
        Route::prefix('base/company')
            ->middleware(['api', 'auth:admin'])
            ->namespace($this->moduleNamespace)
            ->name('base.company.')
            ->group(module_path('Base', '/Routes/company.php'));
    }

    protected function mapCountryRoutes()
    {
        Route::prefix('base/country')
            ->middleware(['api', 'auth:admin'])
            ->namespace($this->moduleNamespace)
            ->name('base.country.')
            ->group(module_path('Base', '/Routes/country.php'));
    }

    protected function mapCurrencyRoutes()
    {
        Route::prefix('base/currency')
            ->middleware(['api', 'auth:admin'])
            ->namespace($this->moduleNamespace)
            ->name('base.currency.')
            ->group(module_path('Base', '/Routes/currency.php'));
    }

    protected function mapPaymentMethodRoutes()
    {
        Route::prefix('base/paymentMethod')
            ->middleware(['api', 'auth:admin'])
            ->namespace($this->moduleNamespace)
            ->name('base.paymentMethod.')
            ->group(module_path('Base', '/Routes/paymentMethod.php'));
    }
}
