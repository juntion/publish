<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AdminInitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(Init\AdminTableInitSeeder::class);
        $this->call(Init\PermissionInitSeeder::class);
        $this->call(Init\RouteInitSeeder::class);
    }
}
