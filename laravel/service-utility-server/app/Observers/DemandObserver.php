<?php

namespace App\Observers;

use App\Enums\ProjectManage\DemandStatus;
use App\Events\PM\Demand\DemandToPush;
use App\ProjectManage\Models\Demand;

class DemandObserver
{
    public function created(Demand $demand)
    {
        $demand->createStatusLog(null, $demand->status);

        // 需求待推送，通知需求负责人
        if ($demand->status == DemandStatus::STATUS_TO_PUSH) {
            event(new DemandToPush($demand));
        }

        $this->demandToAccept($demand);
    }

    public function updated(Demand $demand)
    {
        if ($demand->isDirty('status')) {
            // 记录status 变更日志
            $demand->createStatusLog($demand->getOriginal('status'), $demand->status);

            // 需求待推送，通知需求负责人
            if ($demand->status == DemandStatus::STATUS_TO_PUSH) {
                event(new DemandToPush($demand));
            }

            if ($demand->status == DemandStatus::STATUS_TO_ACCEPT) {
                $this->demandToAccept($demand);
            }
        }

        if ($demand->isDirty('principal_user_id')) {
            $this->demandToAccept($demand);
        }

        // 给关联的人标识update
        $user = $demand->relateUsers();
        $demand->setIsUpdated($user);
    }

    /**
     * 需求待审核，通知产品负责人
     * @param Demand $demand
     */
    protected function demandToAccept(Demand $demand)
    {
        if ($demand->status != DemandStatus::STATUS_TO_ACCEPT) return;
        $title = 'pms需求立项待审核';
        $message = "您有一个新的需求立项申请审核，可前往pms进行查看！";
        sendWSNotification($demand->principal_user_id, $title, $message);
    }
}
