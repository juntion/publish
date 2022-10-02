<?php

use App\Enums\ProjectManage\DesignPartStatus;
use App\Enums\ProjectManage\DesignSubTaskStatus;
use App\Enums\ProjectManage\DevSubTaskStatus;
use App\Enums\ProjectManage\DevTaskStatus;
use App\Enums\ProjectManage\TestSubTaskStatus;
use App\Enums\ProjectManage\TestTaskStatus;
use App\ProjectManage\Models\DesignSubTask;
use App\ProjectManage\Models\DevSubTask;
use App\ProjectManage\Models\TestSubTask;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskDateFix201104 extends Seeder
{
    /**
     * 修复批量添加子任务时（TaskDataFix201024），给已撤销任务也添加了子任务
     *
     * @return void
     */
    public function run()
    {
        logSql();

        $designSubTasks = DesignSubTask::query()->where('status', DesignSubTaskStatus::STATUS_CLOSED)
            ->whereHas('part', function ($query) {
                $query->where('status', DesignPartStatus::STATUS_REVOCATION);
            })->get();
        $designSubTasks->each(function (DesignSubTask $designSubTask) {
            DB::table('pm_design_sub_tasks')->where('id', $designSubTask->id)->update(['status' => DesignSubTaskStatus::STATUS_REVOCATION]);
        });

        $devSubTasks = DevSubTask::query()->where('status', DevSubTaskStatus::STATUS_CLOSED)
            ->whereHas('task', function ($query) {
                $query->where('status', DevTaskStatus::STATUS_REVOCATION);
            })->get();
        $devSubTasks->each(function (DevSubTask $devSubTask) {
            DB::table('pm_dev_sub_tasks')->where('id', $devSubTask->id)->update(['status' => DevSubTaskStatus::STATUS_REVOCATION]);
        });

        $testSubTasks = TestSubTask::query()->where('status', TestSubTaskStatus::STATUS_CLOSED)
            ->whereHas('task', function ($query) {
                $query->where('status', TestTaskStatus::STATUS_REVOCATION);
            })->get();
        $testSubTasks->each(function (TestSubTask $testSubTask) {
            DB::table('pm_test_sub_tasks')->where('id', $testSubTask->id)->update(['status' => TestSubTaskStatus::STATUS_REVOCATION]);
        });
    }
}
