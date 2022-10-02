<?php

namespace App\Traits;

use App\Models\Permission\Permission;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

trait PermissionsTrait
{
    /**
     * 重构getStoredPermission
     * @param $permissions
     * @return mixed
     * @see HasPermissions::getStoredPermission()
     * @author King
     * @version 2019/3/4 11:06
     */
    protected function getStoredPermission($permissions)
    {
        $permissionClass = $this->getPermissionClass();

        if (is_numeric($permissions)) {
            return $permissionClass->findById($permissions, $this->getDefaultGuardName());
        }

        if (is_string($permissions)) {
            return $permissionClass->findByName($permissions, $this->getDefaultGuardName());
        }

        if (is_array($permissions)) {
            return $permissionClass
                ->where(function ($query) use ($permissions) {
                    $query->orWhereIn('name', $permissions)
                        ->orWhereIn('id', $permissions);
                })
                ->whereIn('guard_name', $this->getGuardNames())
                ->get();
        }

        return $permissions;
    }

    /**
     * @param $role
     * @return Role
     * @author King
     * @version 2019/3/7 10:51
     */
    protected function getStoredRoles($role)
    {
        $roleClass = $this->getRoleClass();

        if (is_numeric($role)) {
            return $roleClass->findById($role, $this->getDefaultGuardName());
        }

        if (is_string($role)) {
            return $roleClass->findByName($role, $this->getDefaultGuardName());
        }

        if (is_array($role)) {
            return $roleClass
                ->where(function ($query) use ($role) {
                    $query->orWhereIn('name', $role)
                        ->orWhereIn('id', $role);
                })
                ->whereIn('guard_name', $this->getGuardNames())
                ->get();
        }

        return $role;
    }

    /**
     * @param mixed ...$roles
     * @return $this
     * @author: King
     * @version: 2019/5/17 15:45
     */
    public function assignRole(...$roles)
    {
        $roles = collect($roles)
            ->flatten()
            ->map(function ($role) {
                if (empty($role)) {
                    return false;
                }

                return $this->getStoredRoles($role);
            })
            ->filter(function ($role) {
                return $role instanceof Role;
            })
            ->each(function ($role) {
                $this->ensureModelSharesGuard($role);
            })
            ->map->id
            ->all();

        $model = $this->getModel();

        if ($model->exists) {
            $this->roles()->sync($roles, false);
            $model->load('roles');
        } else {
            $class = \get_class($model);

            $class::saved(
                function ($object) use ($roles, $model) {
                    static $modelLastFiredOn;
                    if ($modelLastFiredOn !== null && $modelLastFiredOn === $model) {
                        return;
                    }
                    $object->roles()->sync($roles, false);
                    $object->load('roles');
                    $modelLastFiredOn = $object;
                });
        }

        $this->forgetCachedPermissions();

        return $this;
    }

    /**
     * @param $role
     * @author: King
     * @version: 2019/5/17 15:45
     */
    public function removeRole($role)
    {
        $this->roles()->detach($this->getStoredRoles($role));

        $this->load('roles');
    }

    /**
     * @param mixed ...$permissions
     * @return $this
     * @author: King
     * @version: 2019/5/17 15:45
     */
    public function givePermissionTo(...$permissions)
    {
        $rolePermissions = [];
        if (!$this instanceof Role) {
            $roles = $this->roles()->with('permissions')->get();
            $rolePermissions = $roles->map->permissions->flatten()->map->id->unique()->all();
        }

        $permissions = collect($permissions)
            ->flatten()
            ->map(function ($permission) {
                if (empty($permission)) {
                    return false;
                }

                return $this->getStoredPermission($permission);
            })
            ->filter(function ($permission) use ($rolePermissions) {
                return $permission instanceof Permission && !in_array($permission->id, $rolePermissions);
            })
            ->each(function ($permission) {
                $this->ensureModelSharesGuard($permission);
            })
            ->map->id
            ->all();

        $model = $this->getModel();

        if ($model->exists) {
            $this->permissions()->sync($permissions, false);
            $model->load('permissions');
        } else {
            $class = \get_class($model);

            $class::saved(
                function ($object) use ($permissions, $model) {
                    static $modelLastFiredOn;
                    if ($modelLastFiredOn !== null && $modelLastFiredOn === $model) {
                        return;
                    }
                    $object->permissions()->sync($permissions, false);
                    $object->load('permissions');
                    $modelLastFiredOn = $object;
                }
            );
        }

        $this->forgetCachedPermissions();

        return $this;
    }
}