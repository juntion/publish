<?php

namespace Modules\Admin\Database\Seeders\Init;

use Modules\Permission\Entities\PermissionType;
use Modules\Permission\Database\Seeders\Init\Contracts\PermissionInitSeeder as Seeder;

class PermissionInitSeeder extends Seeder
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
            PermissionType::$PERMISSION_FEATURE => 'feature',
            PermissionType::$PERMISSION_ROUTE => 'route',
        ];
    }
}
