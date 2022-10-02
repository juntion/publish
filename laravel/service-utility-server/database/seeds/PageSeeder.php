<?php

use Illuminate\Database\Seeder;
use App\Support\Data\PageData;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::createNotExists(PageData::getData());
    }
}
