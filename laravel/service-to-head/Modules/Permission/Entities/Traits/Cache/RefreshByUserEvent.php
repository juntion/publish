<?php

namespace Modules\Permission\Entities\Traits\Cache;

use Chelout\RelationshipEvents\Concerns\HasMorphToManyEvents;
use Modules\Route\Entities\UserIndex;
use Modules\Route\Entities\UserMenu;
use Modules\Permission\Entities\UserPermission;

/**
 * 用户事件                            影响的缓存
 *
 * 1，用户->角色 关系变更              影响用户权限的缓存，影响用户首页的缓存，影响用户侧边栏的缓存
 * 2，用户->权限 关系变更              影响用户权限的缓存，影响用户首页的缓存，影响用户侧边栏的缓存
 */
trait RefreshByUserEvent
{
    use HasMorphToManyEvents;

    public static function bootRefreshByUserEvent()
    {
        static::morphToManyAttaching(function ($relation, $parent, $ids, $attributes) {
            if (!($relation == 'roles' || $relation == 'permissions')) return;
            (new UserPermission())->forget($parent->getKey());
            (new UserIndex())->forget($parent->getKey());
            (new UserMenu())->forget($parent->getKey());
        });

        static::morphToManyDetaching(function ($relation, $parent, $ids) {
            if (!($relation == 'roles' || $relation == 'permissions')) return;
            (new UserPermission())->forget($parent->getKey());
            (new UserIndex())->forget($parent->getKey());
            (new UserMenu())->forget($parent->getKey());
        });
    }
}
