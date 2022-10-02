<?php

namespace App\Observers;

use App\Enums\ProjectManage\AppealStatus;
use App\Events\PM\AppealCompleted;
use App\ProjectManage\Models\Appeal;

class AppealObserver
{
    public function created(Appeal $appeal)
    {
        $appeal->createStatusLog(null, $appeal->status);
    }

    public function updated(Appeal $appeal)
    {
        if ($appeal->isDirty('status')) {
            $appeal->createStatusLog($appeal->getOriginal('status'), $appeal->status);

            // 诉求已完成，通知诉求发布人
            if ($appeal->status == AppealStatus::STATUS_COMPLETED) {
                event(new AppealCompleted($appeal));
            }
        }
    }
}
