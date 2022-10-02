<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTableSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(SubsystemSeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(AdminSidebarSeeder::class);
        // $this->call(CompanySeeder::class);
    }
}
