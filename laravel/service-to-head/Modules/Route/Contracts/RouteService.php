<?php

namespace Modules\Route\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Modules\Base\Entities\User;

interface RouteService
{
    /**
     * 获取用户的首页
     *
     * @param User $user
     * @return \Modules\Route\Entities\Route
     */
    public function getUserIndexRoute(User $user);

    /**
     * 获取用户的菜单
     *
     * @param User $user
     * @return array
     */
    public function getUserMenu(User $user);

    /**
     * 获取用户的所有入口
     *
     * @param User $user
     * @return Collection 集合元素为 \Modules\Route\Entities\Route
     */
    public function getUserRoutes(User $user);

    /**
     * 根据权限集合，返回菜单入口树 数组
     *
     * @param Collection $permissions \Modules\Permission\Entities\Permission 访问入口权限的集合
     * @return array 菜单入口树的数组
     */
    public function getMenuRouteTree(Collection $permissions);

    /**
     * 根据菜单的集合，返回菜单入口树 数组
     *
     * @param Collection $menus \Modules\Route\Entities\RouteMenu
     * @return array 菜单入口树的数组
     */
    public function menuRouteToTree(Collection $menus);
}
