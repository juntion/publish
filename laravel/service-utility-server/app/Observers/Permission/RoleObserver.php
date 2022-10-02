<?php

namespace App\Observers\Permission;

use App\Enums\Permission\PermissionLogType;
use App\Models\Permission\Role;

class RoleObserver
{
    public function updated(Role $role)
    {
        if ($role->isDirty(['comment', 'locale'])) {
            $changes = collect($role->getChanges())->reject(function ($item, $key) {
                return $key == 'updated_at';
            });
            $old = $new = [];
            $changes->map(function ($item, $key) use ($role, &$old, &$new) {
                $old[$key] = $role->getOriginal($key);
                $new[$key] = $item;
            });
            $role->createPermissionLog($old, $new, PermissionLogType::ROLE_PERMISSION, 'update');
        }
    }
}
