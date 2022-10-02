<?php

namespace App\Rpc\Service;


use App\Models\Page;
use App\Models\Permission\Permission;
use App\Models\User;
use App\Rpc\Traits\RpcTrait;

class AuthService
{
    use RpcTrait;

    /**
     * 检查操作权限
     * @param $userId
     * @param $permission
     * @return array
     */
    public function canDo($userId, $permission)
    {
        $user = User::query()->find($userId);
        return self::success($user->can($permission));
    }

    /**
     * 注册权限
     * @param $permissions
     * @return array
     */
    public function registerPermissions($permissions)
    {
        Permission::createNotExists($permissions);
        return self::success();
    }

    /**
     * 注册页面
     * @param $pages
     * @return array
     */
    public function registerPages($pages)
    {
        Page::createNotExists($pages);
        return self::success();
    }

    /**
     * 权限所属角色
     * @param $name
     * @return array
     */
    public function permissionHasRoles($name)
    {
        $permission = Permission::query()->where([
            ['name', $name],
            ['guard_name', request()->header('guardname')]
        ])->first();
        $data = $permission ? $permission->roles()->pluck('id')->toArray() : [];
        return self::success($data);
    }

    /**
     * 用户的权限
     * @param $id
     * @return array
     */
    public function userHasPermissions($id)
    {
        $user = User::query()->find($id);
        $data = $user ? $user->permissions()
            ->where('guard_name', request()->header('guardname'))
            ->pluck('name')
            ->toArray() : [];
        return self::success($data);
    }

    /**
     * 用户的角色
     * @param $id
     * @return array
     */
    public function userHasRoles($id)
    {
        $user = User::query()->find($id);
        $data = $user ? $user->roles()
            ->where('guard_name', request()->header('guardname'))
            ->pluck('id')
            ->toArray() : [];
        return self::success($data);
    }
}