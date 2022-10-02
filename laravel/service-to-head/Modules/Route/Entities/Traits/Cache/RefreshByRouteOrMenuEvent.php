<?php

namespace Modules\Route\Entities\Traits\Cache;

use Modules\Route\Entities\UserIndex;
use Modules\Route\Entities\UserMenu;
use Chelout\RelationshipEvents\Concerns\HasBelongsToManyEvents;

/**
 * [入口|菜单]事件                       影响的缓存
 *
 * 1，[入口|菜单]删除                    影响所有用户的首页和侧边栏关系的缓存
 * 2，[入口|菜单]->[入口|菜单] 关系变更  影响所有用户的首页和侧边栏关系的缓存
 * 3，[入口|菜单]->[入口|菜单] 排序变更  影响所有用户的首页和侧边栏关系的缓存
 */
trait RefreshByRouteOrMenuEvent
{
    use HasBelongsToManyEvents;

    public static function bootRefreshByRouteOrMenuEvent()
    {
        static::deleting(function ($modal) {
            (new UserIndex())->flush();
            (new UserMenu())->flush();
        });

        static::belongsToManyAttaching(function ($relation, $parent, $ids, $attributes) {
            static::refreshUserRouteMenuCache($relation, $parent, $ids);
        });
        static::belongsToManyDetaching(function ($relation, $parent, $ids) {
            static::refreshUserRouteMenuCache($relation, $parent, $ids);
        });
        static::belongsToManyUpdatingExistingPivot(function ($relation, $parent, $ids, $attributes) {
            static::refreshUserRouteMenuCache($relation, $parent, $ids);
        });
    }

    private static function refreshUserRouteMenuCache($relation, $parent, $ids)
    {
        if (!($relation == 'menus' || $relation == 'routes')) return;

        (new UserIndex())->flush();
        (new UserMenu())->flush();
    }
}
