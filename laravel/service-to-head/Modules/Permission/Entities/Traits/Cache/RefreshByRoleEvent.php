<?php

namespace Modules\Permission\Entities\Traits\Cache;

use Chelout\RelationshipEvents\Concerns\HasBelongsToManyEvents;
use Modules\Route\Entities\UserIndex;
use Modules\Route\Entities\UserMenu;
use Modules\Permission\Entities\UserPermission;

/**
 * 角色事件                            影响的缓存
 *
 * 1，角色删除                         影响用户权限的缓存，影响用户首页的缓存，影响用户侧边栏的缓存
 * 2，角色->权限 关系变更              影响用户权限的缓存，影响用户首页的缓存，影响用户侧边栏的缓存
 */
trait RefreshByRoleEvent
{
    use HasBelongsToManyEvents;

    public static function bootRefreshByRoleEvent()
    {
        static::deleting(function ($model) {
            $userPermission = new UserPermission();
            $userIndex = new UserIndex();
            $userMenu = new UserMenu();
            foreach ($model->users as $user) {
                $userPermission->forget($user->getKey());
                $userIndex->forget($user->getKey());
                $userMenu->forget($user->getKey());
            }
        });

        static::belongsToManyAttaching(function ($relation, $parent, $ids, $attributes) {
            static::refreshUserPermissionRelateCache($relation, $parent, $ids);
        });

        static::belongsToManyDetaching(function ($relation, $parent, $ids) {
            static::refreshUserPermissionRelateCache($relation, $parent, $ids);
        });
    }

    public static function refreshUserPermissionRelateCache($relation, $parent, $ids)
    {
        if ($relation != 'permissions') return;

        $userPermission = new UserPermission();
        $userIndex = new UserIndex();
        $userMenu = new UserMenu();
        foreach ($parent->users as $user) {
            $userPermission->forget($user->getKey());
            $userIndex->forget($user->getKey());
            $userMenu->forget($user->getKey());
        }
    }
}
