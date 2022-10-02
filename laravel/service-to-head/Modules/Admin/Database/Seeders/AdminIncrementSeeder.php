<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AdminIncrementSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        
        $this->call(Migrate\ERPAdminIncrement::class);
        $this->call(Migrate\UUMSAdminIncrement::class);
    }
}