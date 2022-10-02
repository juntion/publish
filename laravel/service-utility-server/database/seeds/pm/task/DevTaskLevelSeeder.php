<?php

use App\ProjectManage\Models\DevTask;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevTaskLevelSeeder extends Seeder
{
    /**
     * 修复开发任务新增 level 字段数据
     *
     * @return void
     */
    public function run()
    {
        $devTasks = DevTask::query()->whereNotNull('demand_id')->whereNull('level')->with('demand')->get();
        $devTasks->each(function (DevTask $devTask) {
            if ($level = $devTask->demand->level) {
                // 模型更新会触发事件
                DB::table('pm_dev_tasks')->where('id', $devTask->id)->update(['level' => $level]);
            }
        });
    }
}
