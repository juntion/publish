<?php

use App\Enums\ProjectManage\Releases\ReleaseVersionStatus;
use App\Enums\ProjectManage\Releases\SubTaskReleaseStatus;
use App\ProjectManage\Models\DesignSubTask;
use App\ProjectManage\Models\DevSubTask;
use Illuminate\Database\Seeder;

class FixReleaseVersionTaskReleaseStatus extends Seeder
{
    /**
     * 修复子任务发布测试状态历史数据
     *
     * @return void
     */
    public function run()
    {
        $designSubTasks = DesignSubTask::query()->whereNotNull('release_version_id')->whereNull('release_status')->with('version')->get();
        $designSubTasks->map(function (DesignSubTask $subTask) {
            $releaseStatus = $this->releaseStatus($subTask->version);
            $subTask->update(['release_status' => $releaseStatus]);
        });

        $devSubTasks = DevSubTask::query()->whereNotNull('release_version_id')->whereNull('release_status')->with('version')->get();
        $devSubTasks->map(function (DevSubTask $subTask) {
            $releaseStatus = $this->releaseStatus($subTask->version);
            $subTask->update(['release_status' => $releaseStatus]);
        });
    }

    /**
     * @param $version
     * @return int
     */
    protected function releaseStatus($version)
    {
        return $version->status == ReleaseVersionStatus::TO_TEST ? SubTaskReleaseStatus::NO_RELEASE_TEST : SubTaskReleaseStatus::RELEASED_TEST;
    }
}
