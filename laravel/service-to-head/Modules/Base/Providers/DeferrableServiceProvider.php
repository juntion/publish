<?php

namespace Modules\Base\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Modules\Base\Contracts\ListServiceInterface;
use Modules\Base\Contracts\Oss\OssService;
use Modules\Base\Services\ListService;
use Modules\Base\Contracts\Number\Factory as NumberFactory;
use Modules\Base\Services\NumberService;
use Modules\Base\Services\Oss\AliyunOssService;
use Modules\Base\Contracts\Company\CompanyService as Company;
use Modules\Base\Services\Company\CompanyService;

class DeferrableServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public $bindings = [
        ListServiceInterface::class => ListService::class,
    ];

    public $singletons = [
        NumberFactory::class => NumberService::class,
        OssService::class => AliyunOssService::class,
        Company::class => CompanyService::class,
    ];

    public function provides()
    {
        return [
            ListServiceInterface::class,
            NumberFactory::class,
            OssService::class,
            Company::class,
        ];
    }
}
