<?php

namespace Modules\Permission\Database\Seeders\Init;

use Modules\Permission\Database\Seeders\Init\Contracts\RoleHasPermissionInitSeeder as Seeder;
use Modules\Permission\Entities\PermissionType;

class RoleHasPermissionTableInitSeeder extends Seeder
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
        return ['role_has_permission'];
    }
}
