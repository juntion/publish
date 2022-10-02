<?php

namespace Modules\Finance\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\Finance\Http\Controllers';

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
//        $this->mapApiRoutes();
        $this->mapApiReceipts();
        $this->mapApiVouchers();
        $this->mapApiInvoices();
        $this->mapApiCurrencies();
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
        Route::prefix('finance')
            ->middleware(['api', 'auth:admin'])
            ->namespace($this->moduleNamespace)
            ->name('finance.')
            ->group(module_path('Finance', '/Routes/api.php'));
    }

    protected function mapApiReceipts()
    {
        Route::prefix('finance/receipt')
            ->middleware(['api', 'auth:admin'])
            ->namespace($this->moduleNamespace . '\Receipt')
            ->name('finance.receipt.')
            ->group(module_path('Finance', '/Routes/receipt.php'));
    }

    protected function mapApiVouchers()
    {
        Route::prefix('finance/voucher')
            ->middleware(['api', 'auth:admin'])
            ->namespace($this->moduleNamespace . '\Voucher')
            ->name('finance.voucher.')
            ->group(module_path('Finance', '/Routes/voucher.php'));
    }

    protected function mapApiInvoices()
    {
        Route::prefix('finance/invoice')
            ->middleware(['api'])
            ->namespace($this->moduleNamespace . '\Invoice')
            ->name('finance.invoice.')
            ->group(module_path('Finance', '/Routes/invoice.php'));
    }

    protected function mapApiCurrencies()
    {
        Route::prefix('finance/currency')
            ->middleware(['api', 'auth:admin'])
            ->namespace($this->moduleNamespace . '\Currency')
            ->name('finance.currency.')
            ->group(module_path('Finance', '/Routes/currency.php'));
    }
}
