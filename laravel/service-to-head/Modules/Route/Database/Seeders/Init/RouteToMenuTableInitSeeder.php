<?php

namespace Modules\Route\Database\Seeders\Init;

use Modules\Route\Database\Seeders\Init\Contracts\RouteToMenuInitSeeder as Seeder;
use Modules\Permission\Entities\PermissionType;

class RouteToMenuTableInitSeeder extends Seeder
{
    public function guard()
    {
        return PermissionType::$GUARD_ADMIN;
    }

    public function getDir()
    {
        return __DIR__ . '/Data';
    }

    public function getFiles(): array
    {
        return ['route_to_menu'];
    }
}
