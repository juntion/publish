<?php


namespace Modules\Share\Entities;


use Modules\Base\Contracts\CacheAble\Cache;

class UserStats extends Cache
{
    protected function dataBuild($value)
    {
        return $value;
    }


    protected function dataResolve($value)
    {
        return $value;
    }
}