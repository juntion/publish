<?php

namespace Modules\Permission\Database\Seeders\Init\Contracts;

use Illuminate\Database\Seeder;
use Modules\Permission\Entities\Role;
use Modules\Permission\Entities\Permission;
use Modules\Permission\Entities\PermissionType;

abstract class RoleHasPermissionInitSeeder extends Seeder
{
    public function run()
    {
        collect($this->getData())->each(function ($item) {
            //角色对应的首页权限只能有一个

            //超管权限
            if (is_string($item['permission'])) {
                if ($item['permission'] === 'all') {
                    $role = Role::where(['name' => $item['role'], 'guard_name' => $this->guard()])->first();

                    $permissions = Permission::where('guard_name', $this->guard())
                        ->where('type', '<>', PermissionType::$PERMISSION_INDEX)
                        ->get()->map->uuid->all();
                    $index = Permission::where('guard_name', $this->guard())
                        ->where('name', $item['index'])
                        ->first();
                    $permissions[] = $index->uuid;

                    $role->permissions()->sync($permissions);
                }
            }

            if (is_array($item['permission'])) {
                $role = Role::where(['name' => $item['role'], 'guard_name' => $this->guard()])->first();
                $permissions = Permission::where('guard_name', $this->guard())
                    ->where('type', '<>', PermissionType::$PERMISSION_INDEX)
                    ->whereIn('name', $item['permission'])
                    ->get()->map->uuid->all();

                if (isset($item['index'])) {
                    $index = Permission::where('guard_name', $this->guard())
                        ->where('name', $item['index'])
                        ->first();
                    $permissions[] = $index->uuid;
                }

                $role->permissions()->sync($permissions);
            }
        });
    }

    private function getData()
    {
        $data = [];
        $files = $this->getFiles();

        foreach ($files as $file) {
            $data = array_merge($data, $this->getDataFromFile($file));
        }

        return $data;
    }

    private function getDataFromFile($file)
    {
        return json_decode(file_get_contents($this->getDir() . '/' . ucfirst($this->guard()) . '/' . $file . '.json'), true);
    }

    abstract public function guard();

    abstract public function getDir();

    abstract public function getFiles(): array;
}
