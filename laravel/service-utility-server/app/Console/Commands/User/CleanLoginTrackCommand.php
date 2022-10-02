<?php

namespace App\Console\Commands\User;

use App\Models\LoginTrack;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CleanLoginTrackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:clean-login-track';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '清理用户登录日志（保留6个月）';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = Carbon::now()->addMonths(-6)->format('Y-m-d 00:00:00');
        LoginTrack::query()->where('created_at', '<', $date)->delete();
        $this->info(Carbon::now()->format('Y-m-d H:i:s') . ' 操作成功！');

        return 0;
    }
}
