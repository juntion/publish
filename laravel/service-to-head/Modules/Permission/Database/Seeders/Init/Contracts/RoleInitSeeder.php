<?php

namespace Modules\Permission\Database\Seeders\Init\Contracts;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Permission\Entities\Role;

abstract class RoleInitSeeder extends Seeder
{
    public function run()
    {
        /**
         * 角色名称的命名 $item['name']，不能命名成uuid的格式，正则为/^[0-9a-f]{32}$/
         */
        collect($this->getData())->each(function ($item) {
            Role::modelUpdateOrCreate(
                ['name' => $item['name'], 'guard_name' => $item['guard_name']],
                $item
            );
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
        $list = [];
        $group = json_decode(file_get_contents($this->getDir() . '/' . ucfirst($this->guard()) . '/' . $file . '.json'), true);

        array_walk($group, function ($roles) use (&$list) {
            array_walk($roles, function ($role) use (&$list) {
                $role['uuid'] = Str::uuid()->getHex()->toString();
                $role['guard_name'] = $this->guard();
                $list[] = $role;
            });
        });

        return $list;
    }

    abstract public function guard();

    abstract public function getDir();

    abstract public function getFiles(): array;
}
