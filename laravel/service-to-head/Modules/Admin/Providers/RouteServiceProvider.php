<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\Admin\Http\Controllers';

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
        $this->mapAuthRoutes();
        $this->mapSettingsRoutes();
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
        Route::prefix('admin')
            ->middleware(['api', 'auth:admin'])
            ->namespace($this->moduleNamespace)
            ->group(__DIR__ . '/../Routes/api.php');
    }

    protected function mapAuthRoutes()
    {
        Route::prefix('admin/auth')
            ->middleware('api')
            ->namespace($this->moduleNamespace . '\Auth')
            ->name('admin.auth.')
            ->group(__DIR__ . '/../Routes/auth.php');
    }

    protected function mapSettingsRoutes()
    {
        Route::prefix('admin/settings')
            ->middleware(['api', 'auth:admin'])
            ->namespace($this->moduleNamespace . '\Settings')
            ->name('admin.settings.')
            ->group(__DIR__ . '/../Routes/settings.php');
    }
}
