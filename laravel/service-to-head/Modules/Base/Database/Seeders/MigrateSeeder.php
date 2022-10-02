<?php

namespace Modules\Base\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class MigrateSeeder extends Seeder
{
    protected function warn($message)
    {
        $this->command->warn($message);
        Log::channel('import')->warning($message);
    }

    protected function error($message)
    {
        $this->command->error($message);
        Log::channel('import')->error($message);
    }
}
