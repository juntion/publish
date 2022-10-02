<?php

namespace Modules\Share\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Share\Database\Seeders\Init\CategoriesInitSeeder;
use Modules\Share\Database\Seeders\Init\TagsInitSeeder;
use Modules\Share\Database\Seeders\Init\ERPProductsId;
use Modules\Share\Database\Seeders\Init\ERPProductsModel;

class ShareInitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(Init\PermissionInitSeeder::class);
        $this->call(Init\RouteInitSeeder::class);
        $this->call(CategoriesInitSeeder::class);
        $this->call(TagsInitSeeder::class);
        $this->call(ERPProductsId::class);
        $this->call(ERPProductsModel::class);
    }
}
