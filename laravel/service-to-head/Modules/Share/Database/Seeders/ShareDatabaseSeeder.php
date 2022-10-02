<?php

namespace Modules\Share\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Share\Database\Seeders\Seeders\ShareTableSeeder;

class ShareDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(ShareTableSeeder::class);

    }
}
