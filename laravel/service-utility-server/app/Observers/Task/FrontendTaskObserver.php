<?php

namespace App\Observers\Task;

use App\Enums\ProjectManage\Task\FrontendTaskStatus;
use App\ProjectManage\Models\FrontendTask;

class FrontendTaskObserver
{
    public function created(FrontendTask $task)
    {
        $task->createStatusLog(null, $task->status);

        $this->taskToAudit($task);
    }

    public function updated(FrontendTask $task)
    {
        if ($task->isDirty('status')) {
            $task->createStatusLog($task->getOriginal('status'), $task->status);

            if ($task->status == FrontendTaskStatus::STATUS_TO_AUDIT) {
                $this->taskToAudit($task);
            }
        }

        if ($task->isDirty('main_principal_user_id')) {
            $this->taskToAudit($task);
        }
    }

    /**
     * 开发总任务待审核，通知主负责人
     * @param FrontendTask $task
     */
    protected function taskToAudit(FrontendTask $task)
    {
        if ($task->status != FrontendTaskStatus::STATUS_TO_AUDIT) return;
        $title = 'pms开发任务待审核';
        $msg = '您有一个新的开发总任务需要审核，可前往pms进行查看！';
        sendWSNotification($task->main_principal_user_id, $title, $msg);
    }
}
