<?php

namespace Modules\Route\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Modules\Base\Entities\User;

interface RouteRepository
{
    /**
     * 获取首页入口，根据权限模型对象，返回入口模型对象，或者返回默认的入口
     *
     * @param \Modules\Permission\Entities\Permission|Null
     * @return \Modules\Route\Entities\Route;
     */
    public static function getIndexRoute($permission);

    /**
     * 获取入口，通过权限获取入口
     *
     * @param Collection $permissions
     * @return Collection 元素为\Modules\Route\Entities\Route
     */
    public static function getRoutesByPermissions(Collection $permissions);

    /**
     * 根据权限的集合，返回对应的入口集合 和 菜单集合（所有父级菜单）和 入口菜单对应关系的集合
     *
     * @param Collection $permissions \Modules\Permission\Entities\Permission 访问入口权限的集合
     * @return mixed  返回一个数组 [入口集合(uuid 做键)， 菜单集合(uuid 做键) ，关系的集合(菜单的 uuid 分组)]
     */
    public static function getMenuRouteData(Collection $permissions);

    /**
     * 获取用户的首页入口, 如果没有则缓存
     *
     * @param User $user
     * @param callable $callback 回调应该返回用户的首页入口 \Modules\Route\Entities\Route
     * @return \Modules\Route\Entities\Route
     */
    public static function getUserIndexRouteOrCache(User $user, callable $callback);

    /**
     * 获取用户的侧边栏, 如果没有则缓存
     *
     * @param User $user
     * @param callable $callback 回调应该返回用户的侧边栏数组
     * @return array 返回用户的侧边栏数组
     */
    public static function getUserMenuOrCache(User $user, callable $callback);
}
