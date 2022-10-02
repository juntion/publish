<?php

namespace Modules\Tag\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Modules\Tag\Entities\TagOperationLog;

class ClearOperationLog extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'tag:clear-operation-log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '清理标签相关操作日志(保留6个月)';

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
        $date = Carbon::now()->addMonths(-6)->format('Y-m-d 00:00:00');
        TagOperationLog::query()->where('created_at', '<', $date)->delete();

        $this->info(Carbon::now()->format('Y-m-d H:i:s') . ' 操作成功！');
    }
}
