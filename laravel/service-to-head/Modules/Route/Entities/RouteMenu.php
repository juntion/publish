<?php

namespace Modules\Route\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Base\Entities\Model;
use Modules\Base\Support\CacheAble\ModelCache;
use Modules\Route\Entities\Traits\Cache\RefreshByRouteOrMenuEvent;

class RouteMenu extends Model
{
    use ModelCache, RefreshByRouteOrMenuEvent;

    protected $guarded = [];

    protected $casts = [
        'locale' => 'json',
    ];

    /**
     * 一个分类可以对应多个入口
     */
    public function routes(): BelongsToMany
    {
        return $this->belongsToMany(
            Route::class,
            'route_to_menus',
            'route_menu_uuid',
            'route_uuid'
        )->withPivot('sort')->as('menu_route');
    }

    public function parent()
    {
        return $this->hasOne(RouteMenu::class, 'uuid', 'parent_uuid');
    }

    public function children()
    {
        return $this->hasMany(RouteMenu::class, 'parent_uuid', 'uuid');
    }

    public static function allMenuTree($guard): Collection
    {
        return RouteMenu::where(['parent_uuid' => null, 'guard_name' => $guard])->get()->each(function ($item) {
            $item->menuTree();
        });
    }

    public function menuTree()
    {
        if ($this->children->count()) {
            $this->children->each(function ($item) {
                $item->menuTree();
            });
        }
    }

    public static function allMenuRouteTree($guard): Collection
    {
        $menus = RouteMenu::where(['parent_uuid' => null, 'guard_name' => $guard])->get();
        $menus->loadMissing('routes');

        $menus->each(function ($item) {
            $item->menuRouteTree();
        });

        return $menus;
    }

    public function menuRouteTree()
    {
        if ($this->children->count()) {
            $this->children->loadMissing('routes');
            $this->children->each(function ($item) {
                $item->menuRouteTree();
            });
        }
    }

    public function menuRouteTreeDelete()
    {
        if ($this->children->count()) {
            $this->children->each(function ($item) {
                $item->menuRouteTreeDelete();
            });
        }
        $this->delete();
    }
}
