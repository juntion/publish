<?php

namespace Modules\Route\Database\Seeders\Init\Contracts;

use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Modules\Route\Entities\Route;
use Modules\Permission\Entities\Permission;

abstract class RouteInitSeeder extends Seeder
{
    public function run()
    {
        collect($this->getData())->each(function ($item) {
            Route::modelUpdateOrCreate(
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

    protected function getDataFromFile($type, $name)
    {
        $routes = [];
        $lists = json_decode(file_get_contents($this->getDir() . '/' . ucfirst($this->guard()) . '/Route/' . $name . '.json'), true);

        array_walk($lists, function ($list) use (&$routes, $type) {
            $list['uuid'] = Permission::where(['name' => $list['permission'], 'guard_name' => $this->guard()])->first()->uuid;
            $list['guard_name'] = $this->guard();
            $list['type'] = $type;

            $routes[] = Arr::except($list, 'permission');
        });

        return $routes;
    }

    abstract public function guard();

    abstract public function getDir();

    abstract public function getFiles(): array;
}
