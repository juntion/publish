<?php

namespace Modules\Permission\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PermissionInitSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->call(Init\PermissionTableInitSeeder::class);
        $this->call(Init\RoleTableInitSeeder::class);
        $this->call(Init\RoleHasPermissionTableInitSeeder::class);
        $this->call(Init\AdminHasRoleTableInitSeeder::class);
        $this->call(Init\RouteInitSeeder::class);
    }
}
