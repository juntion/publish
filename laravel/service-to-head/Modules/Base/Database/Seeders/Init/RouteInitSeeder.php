<?php

namespace Modules\Base\Database\Seeders\Init;

use Modules\Permission\Entities\PermissionType;
use Modules\Route\Database\Seeders\Init\Contracts\RouteInitSeeder as Seeder;

class RouteInitSeeder extends Seeder
{
    public function guard()
    {
        return PermissionType::$GUARD_ADMIN;
    }

    public function getDir()
    {
        return __DIR__.'/Data';
    }

    public function getFiles(): array
    {
        return [
            PermissionType::$PERMISSION_ROUTE => 'route',
        ];
    }
}
