<?php

namespace Modules\Base\Providers;

use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;
use Laravel\Scout\EngineManager;
use Modules\Base\Console\ClearOssTempCommand;
use Modules\Base\Console\OpenAuthCommand;
use Modules\Base\Console\SeedEsCommand;
use Modules\Base\Console\SeedInitCommand;
use Modules\Base\Console\SeedMigrateCommand;
use Modules\Base\Console\TempFileClearCommand;
use Modules\Base\Services\ElasticSearch\ElasticSearchEngineCustom;

class BaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SeedInitCommand::class,
                SeedMigrateCommand::class,
                SeedEsCommand::class,
                ClearOssTempCommand::class,
                OpenAuthCommand::class,
                TempFileClearCommand::class,
            ]);

            $this->loadMigrationsFrom(module_path('Base', 'Database/Migrations'));
        }

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'base');

        resolve(EngineManager::class)->extend('elastic-search', function (){
            return new ElasticSearchEngineCustom(
                ClientBuilder::create()
                    ->setHosts(config('scout.elastic-search.hosts'))
                    ->build()
            );
        });
    }
}
