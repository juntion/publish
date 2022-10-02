<?php

use Illuminate\Database\Seeder;
use App\Models\Subsystem;

class SubsystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subsystem::createNotExists(getDataContents('subsystem/subsystems.json'));
    }
}
