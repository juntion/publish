<?php

namespace Modules\Base\Support\Facades;


use Illuminate\Support\Facades\Facade;
use Modules\Base\Contracts\Oss\OssService as OssServiceInterface;

class OssService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return OssServiceInterface::class;
    }
}