<?php

namespace Modules\Tag\Database\Seeders\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Tag\Entities\TagData;
use Modules\Tag\Entities\TagDataSource;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        TagData::factory()->count(10)->create();
        TagDataSource::factory()->count(10)->create();
    }
}
