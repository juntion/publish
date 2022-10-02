<?php

namespace App\Observers\Task;

use App\Enums\ProjectManage\DemandStatus;
use App\Enums\ProjectManage\DesignTaskStatus;
use App\Enums\ProjectManage\DevTaskStatus;
use App\Enums\ProjectManage\Task\FrontendTaskStatus;
use App\Enums\ProjectManage\Task\MobileTaskStatus;
use App\ProjectManage\Models\Demand;

trait TaskObserverTrait
{
    /**
     * 需求开发环节是否全部完成
     * @param Demand $demand
     * @return bool
     */
    public function demandDevPartFinished(Demand $demand): bool
    {
        $otherDesignTasks = $demand->designTasks()->whereNotIn('status', [DesignTaskStatus::STATUS_COMPLETED, DesignTaskStatus::STATUS_REVOCATION])->exists();
        $otherDevTasks = $demand->devTasks()->whereNotIn('status', [DevTaskStatus::STATUS_COMPLETED, DevTaskStatus::STATUS_REVOCATION])->exists();
        $otherFrontendTasks = $demand->frontendTasks()->whereNotIn('status', [FrontendTaskStatus::STATUS_COMPLETED, FrontendTaskStatus::STATUS_REVOCATION])->exists();
        $otherMobileTasks = $demand->mobileTasks()->whereNotIn('status', [MobileTaskStatus::STATUS_COMPLETED, MobileTaskStatus::STATUS_REVOCATION])->exists();

        return !$otherDesignTasks && !$otherDevTasks && !$otherFrontendTasks && !$otherMobileTasks;
    }


    /**
     * @param Demand $demand
     */
    public function syncDemandSubmit(Demand $demand)
    {
        if ($this->demandDevPartFinished($demand)) {
            $demand->update(['status' => DemandStatus::STATUS_SUBMIT]);
        }
    }

    /**
     * @param Demand $demand
     */
    public function syncDemandNoBegin(Demand $demand)
    {
        $designTasks = $demand->designTasks()->whereNotIn('status', [DesignTaskStatus::STATUS_NO_BEGIN, DesignTaskStatus::STATUS_REVOCATION])->exists();
        $devTasks = $demand->devTasks()->whereNotIn('status', [DevTaskStatus::STATUS_NO_BEGIN, DevTaskStatus::STATUS_REVOCATION])->exists();
        $frontendTasks = $demand->frontendTasks()->whereNotIn('status', [FrontendTaskStatus::STATUS_NO_BEGIN, FrontendTaskStatus::STATUS_REVOCATION])->exists();
        $mobileTasks = $demand->mobileTasks()->whereNotIn('status', [MobileTaskStatus::STATUS_NO_BEGIN, MobileTaskStatus::STATUS_REVOCATION])->exists();
        if ((!$devTasks || !$designTasks || !$frontendTasks || !$mobileTasks) && $demand->status < DemandStatus::STATUS_NO_BEGIN) {
            $demandData['status'] = DemandStatus::STATUS_NO_BEGIN;
            $demandData['start_time'] = null;
            $demand->update($demandData);
        }
    }
}
