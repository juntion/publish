<?php

namespace App\Console\Commands\PM;

use App\Enums\ProjectManage\AppealStatus;
use App\ProjectManage\Models\Appeal;
use Illuminate\Console\Command;

class AppealRestore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appeal:restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '修复Appeal的finish_time 错误';

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
     * @return mixed
     */
    public function handle()
    {
        Appeal::query()->where('status', AppealStatus::STATUS_COMPLETED)
            ->whereNull('finish_time')
            ->get()
            ->map(function ($item){
                $logs = $item->statusLogs->where('new_status',AppealStatus::STATUS_COMPLETED)->last();
                if ($logs){
                    $item->update([
                       'finish_time' => $logs->created_at
                    ]);
                }
            });
        $this->info('修复成功');
    }
}
