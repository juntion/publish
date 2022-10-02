<?php

namespace Modules\Route\Database\Seeders\Init\Contracts;

use Illuminate\Database\Seeder;
use Modules\Route\Entities\RouteMenu as Menu;
use Modules\Route\Entities\Route;

abstract class RouteToMenuInitSeeder extends Seeder
{
    public function run()
    {
        collect($this->getData())->each(function ($item) {
            if (is_array($item['route'])) {
                $menu = Menu::where(['name' => $item['menu'], 'guard_name' => $this->guard()])->first();

                $routes = Route::where('guard_name', $this->guard())
                    ->whereIn('name', $item['route'])
                    ->get();

                $sort = array_flip($item['route']);

                $syncRoutes = [];
                foreach ($routes as $route) {
                    $syncRoutes[$route->uuid] = ['sort' => $sort[$route->name]];
                }

                $menu->routes()->sync($syncRoutes);
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
