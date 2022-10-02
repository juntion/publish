<?php

namespace App\ProjectManage\Models\Policies;


use App\Enums\ProjectManage\DemandConfirm;
use App\Enums\ProjectManage\DemandStatus;
use App\Enums\ProjectManage\ProjectStatus;
use App\Models\User;
use App\ProjectManage\Models\Demand;

class DemandPolicy
{
    public function pushDemand(User $user, Demand $demand)
    {
        if (is_null($demand->project)) return false;
        return in_array($user->id, [
                $demand->project->principal_user_id
            ]) && in_array($demand->status, [DemandStatus::STATUS_TO_PUSH])
            && !in_array($demand->project->status, [ProjectStatus::STATUS_COMPLETED, ProjectStatus::STATUS_REVOCATION]);
    }

    public function confirmDemand(User $user, Demand $demand)
    {
        if (is_null($demand->project)) return false;
        return in_array($user->id, [
                $demand->project->principal_user_id
            ]) && in_array($demand->confirmed, [DemandConfirm::NOT_CONFIRM])
            && !in_array($demand->project->status, [ProjectStatus::STATUS_COMPLETED, ProjectStatus::STATUS_REVOCATION]);
    }

    public function cancelConfirmDemand(User $user, Demand $demand)
    {
        if (is_null($demand->project)) return false;
        return in_array($user->id, [
                $demand->project->principal_user_id
            ]) && in_array($demand->confirmed, [DemandConfirm::HAS_CONFIRM])
            && !in_array($demand->project->status, [ProjectStatus::STATUS_COMPLETED, ProjectStatus::STATUS_REVOCATION]);
    }

    public function updateDemand(User $user, Demand $demand)
    {
        return $user->id == $demand->promulgator_id && !in_array($demand->status, [
                DemandStatus::STATUS_COMPLETED,
                DemandStatus::STATUS_REVOCATION]);
    }

    public function pauseDemand(User $user, Demand $demand)
    {
        return $user->id == $demand->promulgator_id && !in_array($demand->status, [
                DemandStatus::STATUS_TO_ACCEPT,
                DemandStatus::STATUS_REJECTED,
                DemandStatus::STATUS_COMPLETED,
                DemandStatus::STATUS_PAUSED,
                DemandStatus::STATUS_REVOCATION]);
    }

    public function continueDemand(User $user, Demand $demand)
    {
        return $user->id == $demand->promulgator_id && in_array($demand->status, [DemandStatus::STATUS_PAUSED]);
    }

    public function revocationDemand(User $user, Demand $demand)
    {
        return $user->id == $demand->promulgator_id && !in_array($demand->status, [
                DemandStatus::STATUS_COMPLETED,
                DemandStatus::STATUS_REVOCATION]);
    }

    public function verifyDemand(User $user, Demand $demand)
    {
        $users = [];
        $users[] = $demand->principal_user_id;
        return in_array($user->id, $users) && in_array($demand->status, [
                DemandStatus::STATUS_TO_ACCEPT,
                DemandStatus::STATUS_REJECTED]);
    }

    public function beginTestDemand(User $user, Demand $demand)
    {
        $canBeginUsers = [
            $demand->promulgator_id,
            $demand->principal_user_id,
        ];
        $demand->devTasks->map(function ($item) use (&$canBeginUsers) {
            array_push($canBeginUsers, $item->principal_user_id);
        });
        $demand->testSubtasks->map(function ($item)use(&$canBeginUsers){
            array_push($canBeginUsers, $item->handler_id);
        });
        $demand->testTasks->map(function ($item)use(&$canBeginUsers){
           array_push($canBeginUsers, $item->principal_user_id);
        });
        return in_array($user->id, $canBeginUsers) && in_array($demand->status, [DemandStatus::STATUS_SUBMIT]);
    }

    public function completeDemand(User $user, Demand $demand)
    {
        return in_array($user->id, [$demand->promulgator_id, $demand->principal_user_id]) && in_array($demand->status, [DemandStatus::STATUS_IN_TEST]);
    }

    /**
     * 设置优先级：需求发布人或产品负责人
     * @param User $user
     * @param Demand $demand
     * @return bool
     */
    public function priority(User $user, Demand $demand)
    {
        $users[] = $demand->promulgator_id;
        $users[] = $demand->principal_user_id;
        return in_array($user->id, $users) &&
            !in_array($demand->status, [DemandStatus::STATUS_COMPLETED, DemandStatus::STATUS_REVOCATION]);
    }

    /**
     * 更改产品负责人：产品负责人；状态：待审核、审核驳回
     * @param User $user
     * @param Demand $demand
     * @return bool
     */
    public function setPrincipal(User $user, Demand $demand)
    {
        return $user->id == $demand->principal_user_id &&
            in_array($demand->status, [DemandStatus::STATUS_TO_ACCEPT, DemandStatus::STATUS_REJECTED]);
    }
}
