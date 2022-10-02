<?php

namespace Modules\Permission\Database\Seeders\Init\Contracts;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Permission\Entities\Permission;

abstract class PermissionInitSeeder extends Seeder
{
    public function run()
    {
        /**
         * 权限名称的命名 $item['name']，不能命名成uuid的格式，正则为/^[0-9a-f]{32}$/
         */
        collect($this->getData())->each(function ($item) {
            Permission::modelUpdateOrCreate(
                ['name' => $item['name'], 'guard_name' => $item['guard_name']],
                $item
            );
        });
    }

    private function getData()
    {
        $data = [];
        $files = $this->getFiles();

        foreach ($files as $type => $name) {
            $data = array_merge($data, $this->getDataFromFile($type, $name));
        }

        return $data;
    }

    protected function getDataFromFile($permissionType, $permissionName)
    {
        $list = [];
        $group = json_decode(file_get_contents($this->getDir() . '/' . ucfirst($this->guard()) . '/Permission/' . $permissionName . '.json'), true);

        array_walk($group, function ($permissions, $key) use (&$list, $permissionType) {
            array_walk($permissions, function ($permission) use (&$list, $permissionType, $key) {
                $permission['uuid'] = Str::uuid()->getHex()->toString();
                $permission['guard_name'] = $this->guard();
                $permission['type'] = $permissionType;
                $permission['group'] = $key;

                $list[] = $permission;
            });
        });

        return $list;
    }

    abstract public function guard();

    abstract public function getDir();

    abstract public function getFiles(): array;
}
