<?php

use App\Models\Permission\PermissionLog;
use Illuminate\Database\Seeder;

class FixPermissionLogDescSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionLogs = PermissionLog::query()->whereNull('description')->get();

        $permissionLogs->map(function (PermissionLog $log) {
            $log->description = PermissionLog::getHumanDesc($log);
            $log->save();
        });
    }
}
