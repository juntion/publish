<?php

namespace App\Observers;

use App\Enums\ProjectManage\DesignPartStatus;
use App\Events\PM\Task\TaskSubmit;
use App\ProjectManage\Models\DesignPart;

class DesignPartObserver
{
    public function created(DesignPart $designPart)
    {
        $designPart->createStatusLog(null, $designPart->status);
    }

    public function updated(DesignPart $designPart)
    {
        if ($designPart->isDirty('status')) {
            $designPart->createStatusLog($designPart->getOriginal('status'), $designPart->status);

            /*if ($designPart->status == DesignPartStatus::STATUS_SUBMIT) {
                event(new TaskSubmit($designPart));
            }*/
        }
    }
}
