<?php

namespace Modules\Permission\Entities\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Permission\Entities\UserPermission;
use Modules\Permission\Entities\Permission;
use Modules\Permission\Entities\Traits\Cache\RefreshByUserEvent;

trait HasPermissions
{
    use RefreshByUserEvent;

    private $allPermissions;

    public static function bootHasPermissions()
    {
        static::deleting(function ($model) {
            $model->permissions()->detach();
        });
    }

    public function permissions(): MorphToMany
    {
        return $this->morphToMany(
            config('permission.models.permission'),
            'model',
            config('permission.table_names.model_has_permissions'),
            config('permission.column_names.model_morph_key'),
            'permission_uuid'
        );
    }

    public function getPermissionsViaRoles(): Collection
    {
        $relationships = ['roles', 'roles.permissions'];

        if (method_exists($this, 'loadMissing')) {
            $this->loadMissing($relationships);
        } else {
            $this->load($relationships);
        }

        return $this->roles->flatMap(function ($role) {
            return $role->permissions;
        })->sort()->values();
    }

    public function getAllPermissions(): Collection
    {
        return $this->allPermissions ?? $this->allPermissions = $this->findOrCreatePermissionsCache();
    }

    public function findOrCreatePermissionsCache()
    {
        $userPermission = new UserPermission();
        return $userPermission->findOrSaveCache($this->getKey(), function (){
            $permissions = $this->permissions;
            if ($this->roles) {
                $permissions = $permissions->merge($this->getPermissionsViaRoles());
            }

            return $permissions;
        });
    }

    public function hasPermissionTo($permission, $guardName = null): bool
    {
        $guardName = $guardName ?: $this->getDefaultGuardName();
        $userPermissions = $this->getAllPermissions();

        if (is_string($permission)) {
            if (preg_match('/^[0-9a-f]{32}$/', $permission)) {
                return $userPermissions->contains(function ($p) use ($permission, $guardName) {
                    return $p->uuid == $permission && $p->guard_name == $guardName;
                });
            } else {
                return $userPermissions->contains(function ($p) use ($permission, $guardName) {
                    return $p->name == $permission && $p->guard_name == $guardName;
                });
            }
        }

        if ($permission instanceof Permission) {
            return $userPermissions->contains(function ($p) use ($permission, $guardName) {
                return $p->uuid == $permission->uuid && $p->guard_name == $guardName;
            });
        }

        return false;
    }

    private static function getDefaultGuardName()
    {
        foreach (config('auth.guards') as $guardName => $guard) {
            if (!isset($guard['provider'])) {
                continue;
            }

            $model = config("auth.providers.{$guard['provider']}.model");

            if ($model === static::class) {
                return $guardName;
            }
        }

        return null;
    }
}
