<?php

namespace Modules\Permission\Database\Seeders\Init;

use Modules\Permission\Database\Seeders\Init\Contracts\RoleInitSeeder as Seeder;
use Modules\Permission\Entities\PermissionType;

class RoleTableInitSeeder extends Seeder
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
        return ['role'];
    }
}
