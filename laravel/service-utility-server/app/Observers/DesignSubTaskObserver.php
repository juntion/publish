<?php

namespace App\Observers;

use App\Enums\ProjectManage\DemandStatus;
use App\Enums\ProjectManage\DesignPartStatus;
use App\Enums\ProjectManage\DesignSubTaskStatus;
use App\Enums\ProjectManage\DesignTaskStatus;
use App\Enums\ProjectManage\DevTaskStatus;
use App\Observers\Task\TaskObserverTrait;
use App\ProjectManage\Models\DesignSubTask;
use App\ProjectManage\Models\ReleaseVersion;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class DesignSubTaskObserver
{
    use TaskObserverTrait;

    public function created(DesignSubTask $designSubTask)
    {
        $designSubTask->createStatusLog(null, $designSubTask->status);
        $this->syncCreatedStatus($designSubTask);
    }

    public function updated(DesignSubTask $designSubTask)
    {
        if ($designSubTask->isDirty('status')) {
            $designSubTask->createStatusLog($designSubTask->getOriginal('status'), $designSubTask->status);

            $this->syncUpdatedStatus($designSubTask);
        }

        if ($designSubTask->isDirty('release_version_id')) {
            ReleaseVersion::changeFeatureCount($designSubTask->getOriginal('release_version_id'),
                $designSubTask->release_version_id);
        }
    }

    /**
     * 状态：未开始
     * 操作：创建子任务 | 设置处理人 | 发布任务
     * @param DesignSubTask $subTask
     */
    private function syncCreatedStatus(DesignSubTask $subTask)
    {
        // 任一子任务更新为 **未开始** 角色环节同步更新为 **未开始**
        // 任一角色环节更新为 **未开始** 总任务同步更新为 **未开始**
        if ($subTask->status == DesignSubTaskStatus::STATUS_NO_BEGIN) {
            $part = $subTask->part()->first();
            $task = $subTask->task()->first();
            if (in_array($part->status, [DesignPartStatus::STATUS_CLOSED, DesignPartStatus::STATUS_TO_ASSIGN])) {
                $part->update(['status' => DesignPartStatus::STATUS_NO_BEGIN]);
            }
            if (in_array($task->status,
                [DesignTaskStatus::STATUS_CLOSED, DesignTaskStatus::STATUS_TO_AUDIT, DesignTaskStatus::STATUS_TO_ASSIGN])) {
                $task->update(['status' => DesignTaskStatus::STATUS_NO_BEGIN]);
            }

            // 创建子任务时，将需求更新到 未处理
            if ($demand = $task->demand()->first()) {
                if ($demand->status < DemandStatus::STATUS_NO_BEGIN) {
                    $demand->update(['status' => DemandStatus::STATUS_NO_BEGIN]);
                }
            }
        }
    }

    private function syncUpdatedStatus(DesignSubTask $subTask)
    {
        $status = $subTask->status;
        switch ($status) {
            case DesignSubTaskStatus::STATUS_NO_BEGIN:
                $this->syncNoBeginStatus($subTask);
                break;
            case DesignSubTaskStatus::STATUS_IN_PROGRESS:
                $this->syncStartStatus($subTask);
                break;
            case DesignSubTaskStatus::STATUS_SUBMIT:
                $this->syncSubmitStatus($subTask);
                break;
            case DesignSubTaskStatus::STATUS_COMPLETED:
                $this->syncCompletedStatus($subTask);
                break;
            case DesignSubTaskStatus::STATUS_PAUSED:
                $this->syncPauseStatus($subTask);
                break;
            case DesignSubTaskStatus::STATUS_REVOCATION:
                $this->syncRevocationStatus($subTask);
                break;
        }
    }

    /**
     * 状态：进行中
     * 操作：开始子任务 | 撤销提交 | 完成验收不合格
     * @param DesignSubTask $subTask
     */
    private function syncStartStatus(DesignSubTask $subTask)
    {

        $part = $subTask->part;
        $task = $subTask->task;

        if (in_array($part->status, [DesignPartStatus::STATUS_NO_BEGIN, DesignPartStatus::STATUS_PAUSED, DesignPartStatus::STATUS_SUBMIT])) {
            $partData = ['status' => DesignPartStatus::STATUS_IN_PROGRESS];
            if (empty($part->start_time)) {
                $partData['start_time'] = now()->toDateTimeString();
            }
            $part->update($partData);
        }

        if (in_array($task->status, [DesignTaskStatus::STATUS_NO_BEGIN, DesignTaskStatus::STATUS_PAUSED, DesignTaskStatus::STATUS_SUBMIT])) {
            $taskData = ['status' => DesignTaskStatus::STATUS_IN_PROGRESS];
            if (empty($task->start_time)) {
                $taskData['start_time'] = now()->toDateTimeString();
            }
            $task->update($taskData);
        }

        // 设计和开发开始 => 需求研发中
        if ($demand = $task->demand()->first()) {
            $demandData = [];
            if (empty($demand->start_time)) {
                $demandData['start_time'] = now()->toDateTimeString();
            }
            if ($demand->status < DemandStatus::STATUS_IN_PROGRESS) {
                $demandData['status'] = DemandStatus::STATUS_IN_PROGRESS;
            }
            $demand->update($demandData);
        }
    }

    /**
     * 状态：提交
     * 操作：提交子任务
     * @param DesignSubTask $subTask
     */
    private function syncSubmitStatus(DesignSubTask $subTask)
    {
        $part = $subTask->part;
        $task = $subTask->task;
        // 全部子任务已经提交或完成 => 环节已提交
        $otherSubTasks = $part->subTasks()
            ->whereNotIn('status', [DesignSubTaskStatus::STATUS_SUBMIT, DesignSubTaskStatus::STATUS_COMPLETED, DesignSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $part->update(['status' => DesignPartStatus::STATUS_SUBMIT]);
        }
        // 全部环节已经提交或完成 => 主任务提交
        $otherParts = $task->parts()
            ->whereNotIn('status', [DesignPartStatus::STATUS_SUBMIT, DesignPartStatus::STATUS_COMPLETED, DesignPartStatus::STATUS_REVOCATION])
            ->get();
        if ($otherParts->isEmpty()) {
            $task->update(['status' => DesignTaskStatus::STATUS_SUBMIT]);
        }
    }

    /**
     * 状态：完成
     * 操作：完成子任务（验收通过）
     * @param DesignSubTask $subTask
     */
    private function syncCompletedStatus(DesignSubTask $subTask)
    {
        $part = $subTask->part;
        $task = $subTask->task;
        // 是否存在除了撤销和完成之外的子任务
        $otherSubTasks = $part->subTasks()
            ->whereNotIn('status', [DesignSubTaskStatus::STATUS_COMPLETED, DesignSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $partData = ['status' => DesignPartStatus::STATUS_COMPLETED];
            if (empty($part->finish_time)) {
                $partData['finish_time'] = now()->toDateTimeString();
            }
            $part->update($partData);

            //是否存在除了撤销和完成之外的环节
            $otherParts = $task->parts()
                ->whereNotIn('status', [DesignPartStatus::STATUS_COMPLETED, DesignPartStatus::STATUS_REVOCATION])
                ->get();
            if ($otherParts->isEmpty()) {
                $taskData = ['status' => DesignTaskStatus::STATUS_COMPLETED];
                if (empty($task->finish_time)) {
                    $taskData['finish_time'] = now()->toDateTimeString();
                }
                $task->update($taskData);
            } else {
                // 设计当前阶段完成，更新下一阶段状态时需要判断下有没有子任务，有则更新下一阶段和其任务状态到未开始，否则是待指派
                $currentStageParts = $task->parts()->whereNotIn('status', [DesignPartStatus::STATUS_COMPLETED, DesignPartStatus::STATUS_REVOCATION])
                    ->where('stage', $part->stage)
                    ->get();
                if ($currentStageParts->isEmpty()) {
                    $nextParts = $task->parts()->whereNotIn('status', [DesignPartStatus::STATUS_COMPLETED, DesignPartStatus::STATUS_REVOCATION])
                        ->where('stage', ($part->stage + 1))
                        ->get();
                    foreach ($nextParts as $nextPart) {
                        if ($nextPart->status == DesignPartStatus::STATUS_CLOSED) {
                            $nextPartSubTasks = $nextPart->subTasks()->where('handler_id', '>', 0)->get();
                            if ($nextPartSubTasks->isEmpty()) {
                                $nextPart->update(['status' => DesignPartStatus::STATUS_TO_ASSIGN]);
                            } else {
                                $nextPart->update(['status' => DesignPartStatus::STATUS_NO_BEGIN]);
                                $nextPartSubTasks->each(function ($item) {
                                    $item->update(['status' => DesignSubTaskStatus::STATUS_NO_BEGIN]);
                                });
                            }
                        }
                    }
                }
            }
        }

        // 需求已提交是，设计和开发总任务全部完成
        if ($demand = $task->demand()->first()) {
            $devTask = $demand->devTasks()->get();
            $designTask = $demand->designTasks()->get();

            $otherDesignTasks = $designTask->whereNotIn('status', [DesignTaskStatus::STATUS_COMPLETED, DesignTaskStatus::STATUS_REVOCATION]);
            $otherDevTasks = $devTask->whereNotIn('status', [DevTaskStatus::STATUS_COMPLETED, DevTaskStatus::STATUS_REVOCATION]);
            // 所有设计和开发任务都是完成或取消，将需求更新到提交
            $this->syncDemandSubmit($demand);

            // 当需求存在开发任务
            if ($devTask->isNotEmpty()) {
                // 所有设计任务都完成，如果开发任务是关闭中就变为待指派
                if ($otherDesignTasks->isEmpty()) {
                    $devTask->map(function ($item) {
                        if ($item->status == DevTaskStatus::STATUS_CLOSED) {
                            $item->update(['status' => DevTaskStatus::STATUS_TO_ASSIGN]);
                        }
                    });
                }
            }
        }
    }

    /**
     * 状态：暂停
     * 操作：暂停子任务
     * @param DesignSubTask $subTask
     */
    private function syncPauseStatus(DesignSubTask $subTask)
    {
        $part = $subTask->part;
        $task = $subTask->task;
        // 是否存在除了撤销和xx之外的子任务
        $otherSubTasks = $part->subTasks()
            ->whereNotIn('status', [DesignSubTaskStatus::STATUS_PAUSED, DesignSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $part->update([
                'status' => DesignPartStatus::STATUS_PAUSED,
                'pause_time' => now(),
            ]);
        }
        //是否存在除了撤销和暂停之外的环节
        $otherParts = $task->parts()
            ->whereNotIn('status', [DesignPartStatus::STATUS_PAUSED, DesignPartStatus::STATUS_REVOCATION])
            ->get();
        if ($otherParts->isEmpty()) {
            $task->update([
                'status' => DesignTaskStatus::STATUS_PAUSED,
                'pause_time' => now(),
            ]);
        }
    }

    /**
     * 状态：撤销
     * @param DesignSubTask $subTask
     */
    private function syncRevocationStatus(DesignSubTask $subTask)
    {
        // 撤销这里会衍生很多其他状态变化

        $task = $subTask->task;
        $part = $subTask->part;

        // 1.撤销之后全为已完成，相当与完成操作

        // 所有子任务撤销,总任务全部撤销
        $otherSubTasks = $part->subTasks()
            ->whereNotIn('status', [DesignSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $part->update(['status' => DesignPartStatus::STATUS_REVOCATION]);
            //是否存在除了撤销之外的环节
            $otherParts = $subTask->task->parts()
                ->whereNotIn('status', [DesignPartStatus::STATUS_REVOCATION])
                ->get();
            // 所有环节都被撤销
            if ($otherParts->isEmpty()) {
                // 设计任务排序 撤销环节不能撤销总任务
                if (!Str::contains(Route::currentRouteName(), 'tasks.design.sequence')) {
                    $task->update(['status' => DesignTaskStatus::STATUS_REVOCATION]);
                    $task->clearMedias();
                }
            } else {
                // 当前阶段被完成或撤销，下一阶段开始
                $currentStageParts = $task->parts()->whereNotIn('status', [DesignPartStatus::STATUS_COMPLETED, DesignPartStatus::STATUS_REVOCATION])
                    ->where('stage', $part->stage)
                    ->get();
                if ($currentStageParts->isEmpty()) {
                    $nextParts = $task->parts()->whereNotIn('status', [DesignPartStatus::STATUS_COMPLETED, DesignPartStatus::STATUS_REVOCATION])
                        ->where('stage', ($part->stage + 1))
                        ->get();
                    foreach ($nextParts as $nextPart) {
                        if ($nextPart->status == DesignPartStatus::STATUS_CLOSED) {
                            $nextPartSubTasks = $nextPart->subTasks()->where('handler_id', '>', 0)->get();
                            if ($nextPartSubTasks->isEmpty()) {
                                $nextPart->update(['status' => DesignPartStatus::STATUS_TO_ASSIGN]);
                            } else {
                                $nextPart->update(['status' => DesignPartStatus::STATUS_NO_BEGIN]);
                                $nextPartSubTasks->each(function ($item) {
                                    $item->update(['status' => DesignSubTaskStatus::STATUS_NO_BEGIN]);
                                });
                            }
                        }
                    }
                }
            }
            return;
        }

        $otherSubTasks = $part->subTasks()
            ->whereNotIn('status', [DesignSubTaskStatus::STATUS_COMPLETED, DesignSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $this->syncCompletedStatus($subTask);
            return;
        }

        // 2.撤销之后为已提交，相当于提交操作
        $otherSubTasks = $part->subTasks()
            ->whereNotIn('status', [DesignSubTaskStatus::STATUS_SUBMIT, DesignSubTaskStatus::STATUS_COMPLETED, DesignSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $this->syncSubmitStatus($subTask);
            return;
        }

        // 3.撤销之后为已暂停，相当于暂停操作
        $otherSubTasks = $part->subTasks()
            ->whereNotIn('status', [DesignSubTaskStatus::STATUS_PAUSED, DesignSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $this->syncPauseStatus($subTask);
            return;
        }

        // 4.撤销之后为进行中，相当于开始操作
        $otherSubTasks = $part->subTasks()
            ->whereIn('status', [DesignSubTaskStatus::STATUS_IN_PROGRESS])
            ->get();
        if ($otherSubTasks->isNotEmpty()) {
            $this->syncStartStatus($subTask);
            return;
        }
    }

    /**
     * 同步未开始状态
     * @param DesignSubTask $subTask
     */
    protected function syncNoBeginStatus(DesignSubTask $subTask)
    {
        $part = $subTask->part;
        $task = $subTask->task;

        $otherSubTasks = $part->subTasks()
            ->whereNotIn('status', [DesignSubTaskStatus::STATUS_NO_BEGIN, DesignSubTaskStatus::STATUS_REVOCATION])
            ->get();
        // 存在其他状态子任务不用处理
        if ($otherSubTasks->isNotEmpty())
            return;

        $partData['status'] = DesignPartStatus::STATUS_NO_BEGIN;
        $partData['start_time'] = null;
        $part->update($partData);

        if (in_array($task->status,
            [DesignTaskStatus::STATUS_CLOSED, DesignTaskStatus::STATUS_TO_AUDIT, DesignTaskStatus::STATUS_TO_ASSIGN])) {
            $task->update(['status' => DesignTaskStatus::STATUS_NO_BEGIN]);
        }

        if ($demand = $task->demand()->first()) {
            $this->syncDemandNoBegin($demand);
        }
    }
}
