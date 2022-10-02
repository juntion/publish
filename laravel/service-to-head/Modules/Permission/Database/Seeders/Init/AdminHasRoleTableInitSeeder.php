<?php

namespace Modules\Permission\Database\Seeders\Init;

use Illuminate\Database\Seeder;
use Modules\Admin\Entities\Admin;
use Modules\Permission\Entities\Role;
use Modules\Permission\Entities\PermissionType;

class AdminHasRoleTableInitSeeder extends Seeder
{
    public function run()
    {
        $root = Admin::where('name', config('app.root'))->first();
        $super = Role::where(['name' => 'super', 'guard_name' => PermissionType::$GUARD_ADMIN])->first();
        $root->roles()->sync($super);

        collect($this->getData())->each(function ($item) {
            if (is_array($item['role'])) {
                $admin = Admin::where('name', $item['admin'])->first();
                $roles = Role::where('guard_name', PermissionType::$GUARD_ADMIN)
                    ->whereIn('name', $item['role'])
                    ->get()->map->uuid->all();
                $admin->roles()->sync($roles);
            }
        });
    }

    private function getData()
    {
        return $this->getDataFromFile(PermissionType::$GUARD_ADMIN);
    }

    private function getDataFromFile($guardName)
    {
        return json_decode(file_get_contents(__DIR__ . '/Data/' . ucfirst($guardName) . '/admin_has_role.json'), true);
    }
}
