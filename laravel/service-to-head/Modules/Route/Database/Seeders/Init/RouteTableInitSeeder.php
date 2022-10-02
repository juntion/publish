<?php

namespace Modules\Route\Database\Seeders\Init;

use Modules\Route\Database\Seeders\Init\Contracts\RouteInitSeeder as Seeder;
use Modules\Permission\Entities\PermissionType;

class RouteTableInitSeeder extends Seeder
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
        return [
            PermissionType::$PERMISSION_ROUTE => 'route',
        ];
    }
}
