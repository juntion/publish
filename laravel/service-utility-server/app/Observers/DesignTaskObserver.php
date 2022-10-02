<?php

namespace App\Observers;

use App\Enums\ProjectManage\DesignTaskStatus;
use App\ProjectManage\Models\DesignTask;

class DesignTaskObserver
{
    public function created(DesignTask $designTask)
    {
        $designTask->createStatusLog(null, $designTask->status);

        $this->taskToAudit($designTask);
    }

    public function updated(DesignTask $designTask)
    {
        if ($designTask->isDirty('status')) {
            $designTask->createStatusLog($designTask->getOriginal('status'), $designTask->status);

            if ($designTask->status == DesignTaskStatus::STATUS_TO_AUDIT) {
                $this->taskToAudit($designTask);
            }
        }

        if ($designTask->isDirty('principal_user_id')) {
            $this->taskToAudit($designTask);
        }
    }

    /**
     * 设计总任务待审核，通知主负责人
     * @param DesignTask $task
     */
    protected function taskToAudit(DesignTask $task)
    {
        if ($task->status != DesignTaskStatus::STATUS_TO_AUDIT) return;
        $title = 'pms设计任务待审核';
        $message = '您有一个新的设计总任务需要审核，可前往pms进行查看！';
        sendWSNotification($task->principal_user_id, $title, $message);
    }
}
