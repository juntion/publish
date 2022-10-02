<?php

namespace App\Observers\Task;

use App\Enums\ProjectManage\DemandStatus;
use App\Enums\ProjectManage\Task\MobileSubTaskStatus;
use App\Enums\ProjectManage\Task\MobileTaskStatus;
use App\ProjectManage\Models\MobileSubTask;
use App\ProjectManage\Models\ReleaseVersion;

class MobileSubTaskObserver
{
    use TaskObserverTrait;

    public function created(MobileSubTask $task)
    {
        $task->createStatusLog(null, $task->status);
        $this->syncCreatedStatus($task);
    }

    public function updated(MobileSubTask $task)
    {
        if ($task->isDirty('status')) {
            $task->createStatusLog($task->getOriginal('status'), $task->status);

            $this->syncUpdatedStatus($task);
        }

        if ($task->isDirty('release_version_id')) {
            ReleaseVersion::changeFeatureCount($task->getOriginal('release_version_id'), $task->release_version_id);
        }
    }

    private function syncCreatedStatus(MobileSubTask $subTask)
    {
        if ($subTask->status == MobileSubTaskStatus::STATUS_NO_BEGIN) {
            $task = $subTask->task()->first();

            // 设置任务状态为未开始
            if (in_array($task->status, [MobileTaskStatus::STATUS_CLOSED, MobileTaskStatus::STATUS_TO_ASSIGN])) {
                $task->update(['status' => MobileTaskStatus::STATUS_NO_BEGIN]);
            }

            // 创建子任务时，将需求更新到 未处理
            if ($demand = $task->demand()->first()) {
                if ($demand->status < DemandStatus::STATUS_NO_BEGIN) {
                    $demand->update(['status' => DemandStatus::STATUS_NO_BEGIN]);
                }
            }
        }
    }

    private function syncUpdatedStatus(MobileSubTask $subTask)
    {
        $status = $subTask->status;
        switch ($status) {
            case MobileSubTaskStatus::STATUS_NO_BEGIN:
                $this->syncNoBeginStatus($subTask);
                break;
            case MobileSubTaskStatus::STATUS_IN_PROGRESS:
                $this->syncStartStatus($subTask);
                break;
            case MobileSubTaskStatus::STATUS_SUBMIT:
                $this->syncSubmitStatus($subTask);
                break;
            case MobileSubTaskStatus::STATUS_COMPLETED:
                $this->syncCompletedStatus($subTask);
                break;
            case MobileSubTaskStatus::STATUS_PAUSED:
                $this->syncPauseStatus($subTask);
                break;
            case MobileSubTaskStatus::STATUS_REVOCATION:
                $this->syncRevocationStatus($subTask);
                break;

        }
    }

    /**
     * 开始子任务 | 撤销提交
     * 变为进行中
     * @param MobileSubTask $subTask
     */
    private function syncStartStatus(MobileSubTask $subTask)
    {
        $task = $subTask->task()->first();
        if (in_array($task->status, [MobileTaskStatus::STATUS_NO_BEGIN, MobileTaskStatus::STATUS_PAUSED, MobileTaskStatus::STATUS_SUBMIT])) {
            $data = ['status' => MobileTaskStatus::STATUS_IN_PROGRESS];
            if (empty($task->start_time)) {
                $data['start_time'] = now()->toDateTimeString();
            }
            $task->update($data);
        }

        if ($demand = $task->demand()->first()) {
            $demandData = [];
            if (empty($demand->start_time)) {
                $demandData['start_time'] = now()->toDateTimeString();
            }
            // 需求研发中是指，设计开发测试任务环节中，只要有点了开始的任务，需求就变为研发中
            if ($demand->status < DemandStatus::STATUS_IN_PROGRESS) {
                $demandData['status'] = DemandStatus::STATUS_IN_PROGRESS;
            }
            $demand->update($demandData);
        }
    }

    /**
     * 提交子任务
     * @param MobileSubTask $subTask
     */
    private function syncSubmitStatus(MobileSubTask $subTask)
    {
        $task = $subTask->task()->first();
        // 全部子任务已提交或完成
        $otherSubTasks = $task->subTasks()
            ->whereNotIn('status', [MobileSubTaskStatus::STATUS_SUBMIT, MobileSubTaskStatus::STATUS_COMPLETED, MobileSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $task->update(['status' => MobileTaskStatus::STATUS_SUBMIT]);
        }
    }

    /**
     * 完成任务
     * @param MobileSubTask $subTask
     */
    private function syncCompletedStatus(MobileSubTask $subTask)
    {
        $task = $subTask->task()->first();
        // 是否存在除了撤销和xx之外的子任务
        $otherSubTasks = $task->subTasks()
            ->whereNotIn('status', [MobileSubTaskStatus::STATUS_COMPLETED, MobileSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $data = ['status' => MobileTaskStatus::STATUS_COMPLETED];
            if (empty($task->finish_time)) {
                $data['finish_time'] = now()->toDateTimeString();
            }
            $task->update($data);
        }

        // 所有设计和开发任务都是完成或取消，将需求更新到提交
        if ($demand = $task->demand()->first()) {
            $this->syncDemandSubmit($demand);
        }
    }


    /**
     * 暂停子任务
     * @param MobileSubTask $subTask
     */
    private function syncPauseStatus(MobileSubTask $subTask)
    {
        $task = $subTask->task()->first();
        // 是否存在除了撤销和暂停之外的子任务
        $otherSubTasks = $task->subTasks()
            ->whereNotIn('status', [MobileSubTaskStatus::STATUS_PAUSED, MobileSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $task->update([
                'status' => MobileTaskStatus::STATUS_PAUSED,
                'pause_time' => now(),
            ]);
        }
    }

    /**
     * 撤销子任务
     * @param MobileSubTask $subTask
     */
    private function syncRevocationStatus(MobileSubTask $subTask)
    {
        $task = $subTask->task()->first();

        // 所有子任务撤销,总任务全部撤销
        $otherSubTasks = $task->subTasks()
            ->whereNotIn('status', [MobileSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $task->update(['status' => MobileTaskStatus::STATUS_REVOCATION]);
            $task->clearMedias();
            return;
        }

        // 1. 相当于完成
        $otherSubTasks = $task->subTasks()
            ->whereNotIn('status', [MobileSubTaskStatus::STATUS_COMPLETED, MobileSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $this->syncCompletedStatus($subTask);
            return;
        }

        // 2.相当于提交
        $otherSubTasks = $task->subTasks()
            ->whereNotIn('status', [MobileSubTaskStatus::STATUS_SUBMIT, MobileSubTaskStatus::STATUS_COMPLETED, MobileSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $this->syncSubmitStatus($subTask);
            return;
        }

        // 3.相当于暂停
        $otherSubTasks = $task->subTasks()
            ->whereNotIn('status', [MobileSubTaskStatus::STATUS_PAUSED, MobileSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $this->syncPauseStatus($subTask);
            return;
        }

        // 4 开始
        $otherSubTasks = $task->subTasks()
            ->whereIn('status', [MobileSubTaskStatus::STATUS_IN_PROGRESS])
            ->get();
        if ($otherSubTasks->isNotEmpty()) {
            $this->syncStartStatus($subTask);
            return;
        }
    }

    private function syncNoBeginStatus(MobileSubTask $subTask)
    {
        $task = $subTask->task()->first();

        $otherSubTasks = $task->subTasks()
            ->whereNotIn('status', [MobileSubTaskStatus::STATUS_NO_BEGIN, MobileSubTaskStatus::STATUS_REVOCATION])
            ->exists();
        if ($otherSubTasks) return;

        $taskData['status'] = MobileTaskStatus::STATUS_NO_BEGIN;
        $taskData['start_time'] = null;
        $task->update($taskData);

        if ($demand = $task->demand()->first()) {
            $this->syncDemandNoBegin($demand);
        }
    }
}
