<?php

namespace Modules\Share\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Modules\Share\Entities\ResourceDownload;
use Modules\Share\Entities\UserStats;

class DeleteOverTimeDownloadData extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'share:delete-overtime-download-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '删除多余的下载记录，每位用户仅保留3个月内的前300条';

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
        // 每个人三个月内的数据 uuid
        $date = Carbon::today()->addMonths(-3);
        ResourceDownload::query()->where('created_at', "<", $date)->delete();
        // 按照人员分组
        $sql = <<<sql
           SELECT uuid 
                FROM
                    (
                SELECT
                    t.uuid,
                IF
                    ( @admin_uuid = t.admin_uuid and @resource_type = t.resource_type, @rank := @rank + 1, @rank := 1 ) AS i,
                    @admin_uuid := t.admin_uuid, @resource_type := t.resource_type 
                FROM
                    ( SELECT admin_uuid, uuid,resource_type FROM share_resource_downloads ORDER BY admin_uuid DESC,resource_type DESC,created_at DESC ) t,
                    ( SELECT @admin_uuid := NULL, @rank := 0, @resource_type := null ) r 
                    ) d 
                WHERE
                    i > 200;
        sql;
        // 执行sql
        collect(DB::select($sql))->chunk(100)->each(function ($item){
            $uuid = collect($item)->pluck('uuid')->all();
            ResourceDownload::query()->whereIn('uuid', $uuid)->delete();
        });
        // 重新建立ES索引
        Artisan::call("scout:flush", [
            'model' => ResourceDownload::class
        ]);
        Artisan::call("scout:import", [
            'model' => ResourceDownload::class
        ]);
        // 删除redis缓存
        (new UserStats())->flush();
    }
}
