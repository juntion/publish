<?php

namespace Modules\Permission\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Modules\Base\Entities\User;

interface PermissionRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    /**
     * 获取用户的角色
     *
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getUserRoles(User $user) ;

    /**
     * 获取用户的直接权限
     *
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getUserPermissions(User $user) ;

    /**
     * 获取用户的所有权限
     *
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getUserAllPermissions(User $user) ;

    /**
     * 得到用户的首页权限
     *
     * @param User $user
     * @return \Modules\Permission\Entities\Permission|null
     */
    public static function getUserIndexPermission(User $user);

    /**
     * 得到用户的入口权限
     *
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection  权限集合 \Modules\Permission\Entities\Permission
     */
    public static function getUserRoutePermission(User $user);

    /**
     * 同步用户的角色
     *
     * @param User $user
     * @param array $roles 角色的uuid数组
     * @param string $defaultRole 用户默认的角色的uuid
     * @return array
     */
    public static function syncUserRoles(User $user, $roles, $defaultRole = '');

    /**
     * 同步用户的权限
     *
     * @param User $user
     * @param array $permissions 权限的uuid 数组
     * @return array
     */
    public static function syncUserPermissions(User $user, $permissions);

    /**
     * 获取权限的分组
     *
     * @param $guard
     * @return mixed
     */
    public static function getGroupPermissionsByGuard($guard);
}
