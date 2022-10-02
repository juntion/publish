<?php

use Illuminate\Database\Seeder;

class FiberstoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DepartmentSeeder::class);
        $this->call(AdminSeeder::class);
    }
}
