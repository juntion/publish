<?php

namespace Modules\Finance\Providers;

use Illuminate\Support\ServiceProvider;

class FinanceServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        // $this->registerViews();
        $this->loadMigrationsFrom(module_path('Finance', 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
//        $this->app->register(PolicyServiceProvider::class);
//        $this->app->register(CommandServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('Finance', 'Config/config.php') => config_path('finance.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Finance', 'Config/config.php'), 'finance'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/finance');

        $sourcePath = module_path('Finance', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/finance';
        }, \Config::get('view.paths')), [$sourcePath]), 'finance');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/finance');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'finance');
        } else {
            $this->loadTranslationsFrom(module_path('Finance', 'Resources/lang'), 'finance');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
