<?php

namespace Modules\Route\Database\Seeders\Init\Contracts;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Modules\Route\Entities\RouteMenu as Menu;

abstract class MenuInitSeeder extends Seeder
{
    public function run()
    {
        collect($this->getData())->each(function ($item) {
            if ($item['parent_name']) {
                $item['parent_uuid'] = Menu::where(['name' => $item['parent_name'], 'guard_name' => $item['guard_name']])->first()->uuid;
            }
            $item = Arr::except($item, 'parent_name');

            Menu::modelUpdateOrCreate(
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
        $menus = json_decode(file_get_contents($this->getDir() . '/' . ucfirst($this->guard()) . '/' . $file . '.json'), true);

        array_walk($menus, function ($menu) use (&$list) {
            $menu['uuid'] = Str::uuid()->getHex()->toString();
            $menu['guard_name'] = $this->guard();
            $list[] = $menu;
        });

        return $list;
    }

    abstract public function guard();

    abstract public function getDir();

    abstract public function getFiles(): array;
}
