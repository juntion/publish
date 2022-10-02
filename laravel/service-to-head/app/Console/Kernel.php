<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('inspire')->everyMinute()->appendOutputTo(storage_path('logs/cron/inspire.log'));

        // Base
        $schedule->command('oss:temp-clear')->everySixHours()->appendOutputTo(storage_path('logs/cron/oss_tmp_clear.log')); // 删除oss的临时文件
        $schedule->command('tempFile:clear')->dailyAt('00:30')->appendOutputTo(storage_path('logs/cron/base_temp_file_clear.log')); // 删除临时文件

        // Share
        $schedule->command('share:delete-overtime-download-data')->dailyAt('00:10')->appendOutputTo(storage_path('logs/cron/share_delete_overtime_download.log'));
        $schedule->command('share:delete-overtime-view-data')->dailyAt('00:10')->appendOutputTo(storage_path('logs/cron/share_delete_overtime_view.log'));

        // Tag
        $schedule->command('tag:clear-operation-log')->monthlyOn(1)->appendOutputTo(storage_path('logs/cron/tag_clear_operation_log.log'));

        // Admin
        $schedule->command('module:seed', ['Admin', '--class=AdminIncrementSeeder'])->dailyAt('00:20')->appendOutputTo(storage_path('logs/cron/admin_increment_seeder.log'));
//        $schedule->command('module:seed-migrate', ['Admin', '--class=AdminMigrateSeeder'])->lastDayOfMonth()->appendOutputTo(storage_path('logs/cron/admin_migrate_seeder.log'));

        // ERP
        $schedule->command('erp:customer-deposit')->everyTenMinutes()->withoutOverlapping()->appendOutputTo(storage_path('logs/cron/erp_customer_deposit.log'));// 自动录单
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
