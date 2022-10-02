<?php

namespace Modules\Tag\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Tag\Database\Seeders\Migrate\TagDataBlogSeeder;
use Modules\Tag\Database\Seeders\Migrate\TagDataSourceBlogSeeder;

class TagMigrateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(TagDataBlogSeeder::class);
        $this->call(TagDataSourceBlogSeeder::class);
    }
}
