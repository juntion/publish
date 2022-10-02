<?php

namespace Modules\Permission\Repositories;

use Modules\Base\Entities\User;
use Prettus\Repository\Eloquent\BaseRepository;
use Modules\Permission\Contracts\PermissionRepository as ContractsPermissionRepository;
use Modules\Permission\Entities\Permission;
use Modules\Permission\Entities\PermissionType;
use Modules\Permission\Entities\PermissionGroup;

class PermissionRepository extends BaseRepository implements ContractsPermissionRepository
{
    public function model()
    {
        return Permission::class;
    }

    public static function getUserRoles(User $user)
    {
        return $user->roles;
    }

    public static function getUserPermissions(User $user)
    {
        return $user->permissions;
    }

    public static function getUserAllPermissions(User $user)
    {
        return $user->getAllPermissions();
    }

    public static function getUserIndexPermission(User $user)
    {
        $defaultRole = $user->roles()->where('is_default', 1)->first();
        if ($defaultRole) {
            return $defaultRole->permissions()->where('type', PermissionType::$PERMISSION_INDEX)->first();
        }

        return null;
    }

    public static function getUserRoutePermission(User $user)
    {
        $permissions = static::getUserAllPermissions($user);

        return $permissions->filter(function ($permission) {
            return $permission->type == PermissionType::$PERMISSION_ROUTE;
        });
    }

    public static function syncUserRoles(User $user, $roles, $defaultRole = '')
    {
        $pivot = [];
        foreach ($roles as $r) {
            $pivot[$r] = ['is_default' => $r == $defaultRole ? 1 : 0];
        }

        return $user->roles()->sync($pivot);
    }

    public static function syncUserPermissions(User $user, $permissions)
    {
        return $user->permissions()->sync($permissions);
    }

    public static function getGroupPermissionsByGuard($guard){
        $groups = [];
        $permissions = Permission::where('guard_name', $guard)->orderBy('name')->get();

        foreach (PermissionGroup::$groups[$guard] as $g) {
            $groups[$g] = [];
            $groups[$g]['name'] = __('permission::group.' . $g);
            $groups[$g]['permissions'] = [];
        }

        foreach ($permissions as $permission) {
            $groups[$permission->group]['permissions'][] = $permission;
        }

        return $groups;
    }
}
