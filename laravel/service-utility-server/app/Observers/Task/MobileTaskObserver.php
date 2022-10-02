<?php

namespace App\Observers\Task;

use App\Enums\ProjectManage\Task\MobileTaskStatus;
use App\ProjectManage\Models\MobileTask;

class MobileTaskObserver
{
    public function created(MobileTask $task)
    {
        $task->createStatusLog(null, $task->status);

        $this->taskToAudit($task);
    }

    public function updated(MobileTask $task)
    {
        if ($task->isDirty('status')) {
            $task->createStatusLog($task->getOriginal('status'), $task->status);

            if ($task->status == MobileTaskStatus::STATUS_TO_AUDIT) {
                $this->taskToAudit($task);
            }
        }

        if ($task->isDirty('main_principal_user_id')) {
            $this->taskToAudit($task);
        }
    }

    /**
     * 开发总任务待审核，通知主负责人
     * @param MobileTask $task
     */
    protected function taskToAudit(MobileTask $task)
    {
        if ($task->status != MobileTaskStatus::STATUS_TO_AUDIT) return;
        $title = 'pms开发任务待审核';
        $msg = '您有一个新的开发总任务需要审核，可前往pms进行查看！';
        sendWSNotification($task->main_principal_user_id, $title, $msg);
    }
}
