<?php

namespace Modules\Permission\Entities;

use Modules\Base\Contracts\CacheAble\Cache;

/**
 * 缓存用户的权限
 *
 * 缓存的field  为用户的uuid
 * 缓存的value  为用户的权限的uuid 数组
 *
 * [
 *    user_uuid => [permissions_uuid,permissions_uuid]
 * ]
 */
class UserPermission extends Cache
{
    /**
     * 将权限集合，转换成uuid 数组
     * @param $value
     * @return mixed
     */
    protected function dataBuild($value)
    {
        return $value->map->uuid->all();
    }

    /**
     * 将uuid数组转换成权限集合
     * @param $value
     * @return mixed
     */
    protected function dataResolve($value)
    {
        if (method_exists(Permission::class, 'findFromCache')) {
            return Permission::findFromCache($value);
        }
        return Permission::find($value);
    }
}
