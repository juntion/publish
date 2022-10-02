<?php

use App\Enums\ProjectManage\DemandLinksType;
use App\ProjectManage\Models\DesignTask;
use App\ProjectManage\Models\DevTask;
use App\ProjectManage\Models\TestTask;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixTaskMainPrincipalSeeder extends Seeder
{
    /**
     * 修复任务主负责人字段（main_principal_user_id，main_principal_user_name）
     *
     * @return void
     */
    public function run()
    {
        $designTasks = DesignTask::query()->where('main_principal_user_id', 0)->with('demand.demandLinks')->get();
        $designTasks->map(function (DesignTask $task) {
            $principalData = [];
            // 内部任务 => 发布人
            if (empty($task->demand_id)) {
                $principalData = [
                    'main_principal_user_id' => $task->promulgator_id,
                    'main_principal_user_name' => $task->promulgator_name,
                ];
            } else {
                $demandLink = $task->demand->demandLinks->where('type', DemandLinksType::TYPE_DESIGN)->first();
                if ($demandLink) {
                    $principalData = [
                        'main_principal_user_id' => $demandLink->principal_user_id,
                        'main_principal_user_name' => $demandLink->principal_user_name,
                    ];
                }
            }
            if ($principalData) {
                DB::table('pm_design_tasks')->where('id', $task->id)->update($principalData);
            }
        });

        $devTasks = DevTask::query()->where('main_principal_user_id', 0)->with('demand.demandLinks')->get();
        $devTasks->map(function (DevTask $task) {
            $principalData = [];
            // 内部任务 => 发布人
            if (empty($task->demand_id)) {
                $principalData = [
                    'main_principal_user_id' => $task->promulgator_id,
                    'main_principal_user_name' => $task->promulgator_name,
                ];
            } else {
                $demandLink = $task->demand->demandLinks->where('type', DemandLinksType::TYPE_DEVELOP)->first();
                if ($demandLink) {
                    $principalData = [
                        'main_principal_user_id' => $demandLink->principal_user_id,
                        'main_principal_user_name' => $demandLink->principal_user_name,
                    ];
                }
            }
            if ($principalData) {
                DB::table('pm_dev_tasks')->where('id', $task->id)->update($principalData);
            }
        });

        $testTasks = TestTask::query()->where('main_principal_user_id', 0)->with('demand.demandLinks')->get();
        $testTasks->map(function (TestTask $task) {
            $principalData = [];
            // 内部任务 => 发布人
            if (empty($task->demand_id)) {
                $principalData = [
                    'main_principal_user_id' => $task->promulgator_id,
                    'main_principal_user_name' => $task->promulgator_name,
                ];
            } else {
                $demandLink = $task->demand->demandLinks->where('type', DemandLinksType::TYPE_TEST)->first();
                if ($demandLink) {
                    $principalData = [
                        'main_principal_user_id' => $demandLink->principal_user_id,
                        'main_principal_user_name' => $demandLink->principal_user_name,
                    ];
                }
            }
            if ($principalData) {
                DB::table('pm_test_tasks')->where('id', $task->id)->update($principalData);
            }
        });
    }
}
