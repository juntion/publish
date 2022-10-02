<?php

namespace Modules\Route\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Base\Entities\User;
use Modules\Route\Contracts\RouteRepository as ContractsRouteRepository;
use Modules\Route\Entities\Route;
use Modules\Route\Entities\RouteMenu;
use Modules\Route\Entities\UserIndex;
use Modules\Route\Entities\UserMenu;

class RouteRepository implements ContractsRouteRepository
{
    public function model()
    {
        return Route::class;
    }

    /**
     * 获取用户的首页入口, 如果没有则缓存
     *
     * @param User $user
     * @param callable $callback 回调应该返回用户的首页入口 \Modules\Route\Entities\Route
     * @return \Modules\Route\Entities\Route
     */
    public static function getUserIndexRouteOrCache(User $user, callable $callback)
    {
        $userIndex = new UserIndex();
        return $userIndex->findOrSaveCache($user->getKey(), function () use ($callback) {
            return $callback();
        });
    }

    /**
     * 获取用户的侧边栏, 如果没有则缓存
     *
     * @param User $user
     * @param callable $callback 回调应该返回用户的侧边栏数组
     * @return array 返回用户的侧边栏数组
     */
    public static function getUserMenuOrCache(User $user, callable $callback)
    {
        $userMenu = new UserMenu();
        return $userMenu->findOrSaveCache($user->getKey(), function () use ($callback) {
            return $callback();
        });
    }

    /**
     * 获取首页入口，根据权限模型对象，返回入口模型对象，或者返回默认的入口
     *
     * @param \Modules\Permission\Contracts\Permission|Null
     * @return \Modules\Route\Entities\Route;
     */
    public static function getIndexRoute($permission)
    {
        if ($permission) {
            return $permission->route;
        }

        $guard = auth()->getDefaultDriver();
        return Route::where(['name' => 'home', 'guard_name' => $guard])->first();
    }

    public static function getRoutesByPermissions(Collection $permissions)
    {
        $routes = new Collection();
        foreach ($permissions as $p) {
            $routes->push(Route::findFromCache($p->getKey()));
        }

        return $routes;
    }

    /**
     * 根据权限的集合，返回对应的入口集合 和 菜单集合（所有父级菜单）和 入口菜单对应关系的集合
     *
     * @param Collection $permissions \Modules\Permission\Entities\Permission 访问入口权限的集合
     * @return mixed  返回一个数组 [入口集合(uuid 做键)， 菜单集合(uuid 做键) ，关系的集合(菜单的 uuid 分组)]
     */
    public static function getMenuRouteData(Collection $permissions)
    {
        //加载入口权限对应的入口,对应的侧边栏
        $permissions->loadMissing(['route', 'route.menus']);

        //获取用户的所有访问入口
        $routes = $permissions->map(function ($permission) {
            return $permission->route;
        })->keyBy('uuid');

        //入口映射到侧边栏的数组
        $routeToMenu = [];
        $routes->each(function ($route) use (&$routeToMenu) {
            $route->menus->each(function ($menu) use (&$routeToMenu) {
                $routeToMenu[] = $menu->route_menu;
            });
        });
        //将入口按照侧边栏进行分组，并排序
        $menuToRoute = collect($routeToMenu)->groupBy('route_menu_uuid');

        //获取访问入口对应的侧边栏
        $menus = $routes->flatMap(function ($route) {
            return $route->menus;
        })->unique('uuid')->keyBy('uuid');
        //获取所有侧边栏的所有父级侧边栏
        static::collectParentMenus($menus);

        return [$routes, $menus, $menuToRoute];
    }

    /**
     * 收集菜单集合的所有父级菜单
     * @param Collection $menus
     */
    private static function collectParentMenus($menus)
    {
        // foreach 开始时 已经将集合的元素创建了迭代器，循环运行中添加到集合的元素，不会循环。
        foreach ($menus as $menu) {
            static::collectParentMenu($menus, $menu);
        }
    }

    /**
     * 递归获取父级菜单
     * @param Collection $menus 容器
     * @param $menu              菜单对象
     */
    private static function collectParentMenu($menus, $menu)
    {
        $parentUuid = $menu->parent_uuid;

        if (!$parentUuid || $menus->has($parentUuid)) {
            return;
        }

        $parentMenu = RouteMenu::find($parentUuid);
        $menus->put($parentUuid, $parentMenu);
        static::collectParentMenu($menus, $parentMenu);
    }
}
