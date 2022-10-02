<?php

namespace Modules\Route\Entities;

use Modules\Base\Contracts\CacheAble\Cache;

/**
 * 缓存用户的首页
 *
 * 缓存的field  为用户的uuid
 * 缓存的value  为用户的首页权限的入口的uuid
 *
 * [
 *    user_uuid => route_uuid
 * ]
 */
class UserIndex extends Cache
{
    /**
     * 将入口对象转换成  uuid
     * @param $value
     * @return mixed
     */
    protected function dataBuild($value)
    {
        return $value->getKey();
    }

    /**
     * 将uuid 转换成入口对象
     * @param $value
     * @return mixed
     */
    protected function dataResolve($value)
    {
        if (method_exists(Route::class, 'findFromCache')) {
            return Route::findFromCache($value);
        }
        return Route::find($value);
    }
}
