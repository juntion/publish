<?php

namespace Modules\Route\Entities;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Base\Entities\Model;
use Modules\Base\Support\CacheAble\ModelCache;
use Modules\Route\Entities\Traits\Cache\RefreshByRouteOrMenuEvent;

class Route extends Model
{
    use ModelCache, RefreshByRouteOrMenuEvent;

    protected $guarded = [];

    protected $casts = [
        'locale' => 'json',
    ];

    /**
     * 一个入口可以对应多个分类
     */
    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(
            RouteMenu::class,
            'route_to_menus',
            'route_uuid',
            'route_menu_uuid'
        )->withPivot('sort')->as('route_menu');
    }

    /**
     * 一个入口就是一个权限
     */
    public function permission()
    {
        return $this->belongsTo('Modules\Permission\Entities\Permission', 'uuid', 'uuid');
    }
}
