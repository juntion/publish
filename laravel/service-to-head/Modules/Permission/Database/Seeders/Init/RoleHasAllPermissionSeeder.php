<?php

namespace Modules\Permission\Database\Seeders\Init;

use Illuminate\Database\Seeder;
use Modules\Permission\Entities\Role;
use Modules\Permission\Entities\Permission;
use Modules\Permission\Entities\PermissionType;

class RoleHasAllPermissionSeeder extends Seeder
{
    public function run()
    {
        //超管权限
        $role = Role::where(['name' => 'super', 'guard_name' => PermissionType::$GUARD_ADMIN])->first();

        $permissions = Permission::where('guard_name', PermissionType::$GUARD_ADMIN)
            ->where('type', '<>', PermissionType::$PERMISSION_INDEX)
            ->get()->map->uuid->all();

        $role->permissions()->syncWithoutDetaching($permissions);
    }
}
