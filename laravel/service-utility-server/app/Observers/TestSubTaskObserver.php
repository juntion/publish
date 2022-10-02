<?php

namespace App\Observers;

use App\Enums\ProjectManage\DemandStatus;
use App\Enums\ProjectManage\DevTaskStatus;
use App\Enums\ProjectManage\TestSubTaskStatus;
use App\Enums\ProjectManage\TestTaskStatus;
use App\Exceptions\System\InvalidStatusException;
use App\ProjectManage\Models\TestSubTask;

class TestSubTaskObserver
{
    public function created(TestSubTask $testSubTask)
    {
        $testSubTask->createStatusLog(null, $testSubTask->status);

        $this->syncCreatedStatus($testSubTask);
    }

    /**
     * 测试子任务创建状态联动
     * @param TestSubTask $testSubTask
     */
    protected function syncCreatedStatus(TestSubTask $testSubTask)
    {
        $task = $testSubTask->task()->first();

        // 直接创建一个待发布状态子任务
        if ($testSubTask->status == TestSubTaskStatus::STATUS_TO_RELEASE) {
            // 测试总任务指派处理人操作，总任务状态变为待发布状态，（当总任务已经为“待测试”状态时，不改变总任务状态）
            if (in_array($task->status, [TestTaskStatus::STATUS_CLOSED, TestTaskStatus::STATUS_TO_ASSIGN])) {
                $task->update(['status' => TestTaskStatus::STATUS_TO_RELEASE]);
            }
        } else if ($testSubTask->status == TestSubTaskStatus::STATUS_NO_BEGIN) {
            // 同步主任务状态为未开始
            if (in_array($task->status, [TestTaskStatus::STATUS_CLOSED, TestTaskStatus::STATUS_TO_ASSIGN])) {
                $task->update(['status' => TestTaskStatus::STATUS_NO_BEGIN]);
            }
        }

        // 创建子任务时，将需求更新到 未处理
        if ($demand = $task->demand()->first()) {
            if ($demand->status < DemandStatus::STATUS_NO_BEGIN) {
                $demand->update(['status' => DemandStatus::STATUS_NO_BEGIN]);
            }
        }
    }

    public function updated(TestSubTask $testSubTask)
    {
        if ($testSubTask->isDirty('status')) {
            // 记录status 变更日志
            $testSubTask->createStatusLog($testSubTask->getOriginal('status'), $testSubTask->status);

            $this->syncUpdatedStatus($testSubTask);
        }
    }

    protected function syncUpdatedStatus(TestSubTask $testSubTask)
    {
        $status = $testSubTask->status;
        switch ($status) {
            case TestSubTaskStatus::STATUS_NO_BEGIN:
                $this->syncNoBeginStatus($testSubTask);
                break;
            case TestSubTaskStatus::STATUS_IN_TEST:
                $this->syncStartStatus($testSubTask);
                break;
            case TestSubTaskStatus::STATUS_COMPLETED:
                $this->syncCompletedStatus($testSubTask);
                break;
            case TestSubTaskStatus::STATUS_PAUSED:
                $this->syncPauseStatus($testSubTask);
                break;
            case TestSubTaskStatus::STATUS_REVOCATION:
                $this->syncRevocationStatus($testSubTask);
                break;
            case TestSubTaskStatus::STATUS_SUBMIT:
                $this->syncSubmitStatus($testSubTask);
                break;
            case TestSubTaskStatus::STATUS_TO_RELEASE:
                $this->syncReleaseStatus($testSubTask);
                break;
        }
    }

    /**
     * 设置处理人操作将子任务更改到待发布状态
     * @param TestSubTask $testSubTask
     */
    protected function syncReleaseStatus(TestSubTask $testSubTask)
    {
        $task = $testSubTask->task()->first();
        // 测试总任务指派处理人操作，总任务状态变为待发布状态，（当总任务已经为“待测试”状态时，不改变总任务状态）
        if (in_array($task->status, [TestTaskStatus::STATUS_CLOSED, TestTaskStatus::STATUS_TO_ASSIGN])) {
            $task->update(['status' => TestTaskStatus::STATUS_TO_RELEASE]);
        }
    }

    /**
     * 开始测试子任务 测试中
     * @param TestSubTask $subTask
     */
    protected function syncStartStatus(TestSubTask $subTask)
    {
        $task = $subTask->task;
        if (in_array($task->status, [
            TestTaskStatus::STATUS_TO_RELEASE,
            TestTaskStatus::STATUS_TO_ASSIGN,
            TestTaskStatus::STATUS_NO_BEGIN,
            TestTaskStatus::STATUS_SUBMIT,
            TestTaskStatus::STATUS_PAUSED])) {
            $data['status'] = TestTaskStatus::STATUS_IN_TEST;
            if (empty($task->start_time)) {
                $data['start_time'] = now()->toDateTimeString();
            }
            $task->update($data);
        }

        // 需求测试中是，测试任务点击了开始
        if ($demand = $task->demand()->first()) {
            $demandData = [];
            if (empty($demand->start_time)) {
                $demandData['start_time'] = now()->toDateTimeString();
            }
            if ($demand->status < DemandStatus::STATUS_IN_TEST) {
                $demandData['status'] = DemandStatus::STATUS_IN_TEST;
            }
            $demand->update($demandData);
        }
    }

    /**
     * 完成子任务
     * @param TestSubTask $subTask
     */
    protected function syncCompletedStatus(TestSubTask $subTask)
    {
        $task = $subTask->task()->first();
        // 是否存在除了撤销和完成之外的子任务
        $otherSubTasks = $task->subTasks()
            ->whereNotIn('status', [TestSubTaskStatus::STATUS_COMPLETED, TestSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $data = ['status' => TestTaskStatus::STATUS_COMPLETED];
            if (empty($task->finish_time)) {
                $data['finish_time'] = now()->toDateTimeString();
            }
            $task->update($data);

            if ($demand = $task->demand()->first()) {
                // 是否存在没完成的开发任务
                $otherDevTasks = $demand->devTasks()
                    ->whereNotIn('status', [DevTaskStatus::STATUS_COMPLETED, DevTaskStatus::STATUS_REVOCATION])
                    ->get();
                if ($otherDevTasks->isNotEmpty()) {
                    throw new InvalidStatusException('操作不合法，请先完成开发任务');
                }
            }
        }
    }

    /**
     * 暂停子任务
     * @param TestSubTask $subTask
     */
    protected function syncPauseStatus(TestSubTask $subTask)
    {
        $task = $subTask->task;
        // 是否存在除了撤销和暂停之外的子任务
        $otherSubTasks = $task->subTasks()
            ->whereNotIn('status', [TestSubTaskStatus::STATUS_PAUSED, TestSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $task->update([
                'status' => TestTaskStatus::STATUS_PAUSED,
                'pause_time' => now(),
            ]);
        }
    }

    /**
     * 提交子任务
     * @param TestSubTask $testSubTask
     */
    private function syncSubmitStatus(TestSubTask $subTask)
    {
        $task = $subTask->task;
        // 是否存在除了撤销和提交之外的子任务
        $otherSubTasks = $task->subTasks()
            ->whereNotIn('status', [TestSubTaskStatus::STATUS_SUBMIT, TestSubTaskStatus::STATUS_COMPLETED, TestSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $task->update(['status' => TestTaskStatus::STATUS_SUBMIT]);
        }
    }

    /**
     * @param TestSubTask $subTask
     */
    private function syncRevocationStatus(TestSubTask $subTask)
    {
        $task = $subTask->task()->first();

        // 所有子任务撤销,总任务全部撤销
        $otherSubTasks = $task->subTasks()
            ->whereNotIn('status', [TestSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $task->update(['status' => TestTaskStatus::STATUS_REVOCATION]);
            $task->clearMedias();
            return;
        }

        // 完成
        $otherSubTasks = $task->subTasks()
            ->whereNotIn('status', [TestSubTaskStatus::STATUS_COMPLETED, TestSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $this->syncCompletedStatus($subTask);
            return;
        }

        // 提交
        $otherSubTasks = $task->subTasks()
            ->whereNotIn('status', [TestSubTaskStatus::STATUS_SUBMIT, TestSubTaskStatus::STATUS_COMPLETED, TestSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $this->syncSubmitStatus($subTask);
            return;
        }

        // 暂停
        $otherSubTasks = $task->subTasks()
            ->whereNotIn('status', [TestSubTaskStatus::STATUS_PAUSED, TestSubTaskStatus::STATUS_REVOCATION])
            ->get();
        if ($otherSubTasks->isEmpty()) {
            $this->syncPauseStatus($subTask);
            return;
        }

        // 开始
        $otherSubTasks = $task->subTasks()
            ->whereIn('status', [TestSubTaskStatus::STATUS_IN_TEST])
            ->get();
        if ($otherSubTasks->isNotEmpty()) {
            $this->syncStartStatus($subTask);
            return;
        }
    }

    private function syncNoBeginStatus(TestSubTask $testSubTask)
    {
        $task = $testSubTask->task()->first();

        $otherSubTasks = $task->subTasks()->whereNotIn('status', [TestSubTaskStatus::STATUS_NO_BEGIN, TestSubTaskStatus::STATUS_REVOCATION])->exists();
        if ($otherSubTasks) return;

        $taskData['status'] = TestTaskStatus::STATUS_NO_BEGIN;
        $taskData['start_time'] = null;
        $task->update($taskData);

        if ($demand = $task->demand()->first()) {
            $otherTestTasks = $demand->testTasks()->whereNotIn('status', [TestTaskStatus::STATUS_NO_BEGIN, TestTaskStatus::STATUS_REVOCATION])->exists();
            if (!$otherTestTasks) {
                $demand->update(['status' => DemandStatus::STATUS_TO_TEST]);
            }
        }
    }
}
