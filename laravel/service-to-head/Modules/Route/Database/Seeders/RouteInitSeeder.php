<?php

namespace Modules\Route\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RouteInitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        $this->call(Init\PermissionInitSeeder::class);

        $this->call(Init\RouteTableInitSeeder::class);
        $this->call(Init\MenuTableInitSeeder::class);
        $this->call(Init\RouteToMenuTableInitSeeder::class);
    }
}
