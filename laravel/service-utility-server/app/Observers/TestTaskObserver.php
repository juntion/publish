<?php

namespace App\Observers;

use App\Enums\ProjectManage\TestTaskStatus;
use App\ProjectManage\Models\TestTask;

class TestTaskObserver
{
    public function created(TestTask $task)
    {
        $task->createStatusLog(null, $task->status);

        $this->taskToAudit($task);
    }

    public function updated(TestTask $task)
    {
        if ($task->isDirty('status')) {
            // 记录status 变更日志
            $task->createStatusLog($task->getOriginal('status'), $task->status);

            if ($task->status == TestTaskStatus::STATUS_TO_AUDIT) {
                $this->taskToAudit($task);
            }
        }

        if ($task->isDirty('main_principal_user_id')) {
            $this->taskToAudit($task);
        }
    }

    /**
     * 测试总任务待审核，通知主负责人
     * @param TestTask $task
     */
    protected function taskToAudit(TestTask $task)
    {
        if ($task->status != TestTaskStatus::STATUS_TO_AUDIT) return;
        $title = 'pms测试任务待审核';
        $msg = '您有一个新的测试总任务需要审核，可前往pms进行查看！';
        sendWSNotification($task->main_principal_user_id, $title, $msg);
    }
}
