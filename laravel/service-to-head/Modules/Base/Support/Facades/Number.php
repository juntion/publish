<?php


namespace Modules\Base\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Base\Contracts\Number\Factory;

class Number extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}
