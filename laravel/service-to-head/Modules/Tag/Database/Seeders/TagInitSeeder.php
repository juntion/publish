<?php

namespace Modules\Tag\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class TagInitSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->call(Init\PermissionInitSeeder::class);
        $this->call(Init\RouteInitSeeder::class);
    }
}
