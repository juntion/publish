<?php

namespace Modules\Share\Database\Seeders\Seeders;

use Illuminate\Database\Seeder;
use Modules\Share\Entities\CollectionCategory;
use Modules\Share\Entities\Resource;
use Modules\Share\Entities\ResourceCategory;
use Modules\Share\Entities\ResourceTag;

class ShareTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Resource::factory()->count(100)->create();
        ResourceCategory::factory()->count(100)->create();
        CollectionCategory::factory()->count(100)->create();
        ResourceTag::factory()->count(100)->create();
    }
}
