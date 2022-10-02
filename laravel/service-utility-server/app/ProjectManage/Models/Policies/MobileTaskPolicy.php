<?php

namespace App\ProjectManage\Models\Policies;

use App\Enums\ProjectManage\Task\MobileTaskStatus;
use App\Enums\ProjectManage\ProductStatus;
use App\Enums\ProjectManage\TeamType;
use App\Models\User;
use App\ProjectManage\Models\MobileTask;

class MobileTaskPolicy
{
    /**
     * 更改开发总任务负责人：必须有来源需求，产品维护的默认开发负责人是当前登录用户
     * @param User $user
     * @param MobileTask $task
     * @return bool
     */
    public function setPrincipal(User $user, MobileTask $task)
    {
        $demand = $task->demand;
        if (!$demand) {
            return false;
        }
        $product = $demand->products->where('type', ProductStatus::TypeProduct)->first();
        $team = $product->teams->where('type', TeamType::TYPE_MOBILE)->where('is_default', 1)->first();
        $demand->products->each(function ($product) {
            unset($product->teams);
        });
        if (!$team) {
            return false;
        }
        return $user->id == $team->user_id &&
            in_array($task->status, [
                MobileTaskStatus::STATUS_CLOSED,
                MobileTaskStatus::STATUS_TO_ASSIGN,
            ]);
    }

    /**
     * 创建子任务：开发负责人
     * @param User $user
     * @param MobileTask $task
     * @return bool
     */
    public function createSubTask(User $user, MobileTask $task)
    {
        return $user->id == $task->principal_user_id &&
            in_array($task->status, [
                MobileTaskStatus::STATUS_NO_BEGIN,
                MobileTaskStatus::STATUS_IN_PROGRESS,
                MobileTaskStatus::STATUS_SUBMIT,
            ]);
    }

    /**
     * 设置优先级：任务发布人或主负责人
     * @param User $user
     * @param MobileTask $task
     * @return bool
     */
    public function priority(User $user, MobileTask $task)
    {
        return in_array($user->id, [$task->promulgator_id, $task->main_principal_user_id]) &&
            !in_array($task->status, [
                MobileTaskStatus::STATUS_COMPLETED,
                MobileTaskStatus::STATUS_REVOCATION,
            ]);
    }

    /**
     * 指派任务处理人：开发负责人
     * @param User $user
     * @param MobileTask $task
     * @return bool
     */
    public function setHandler(User $user, MobileTask $task)
    {
        return $user->id == $task->principal_user_id &&
            in_array($task->status, [
                MobileTaskStatus::STATUS_CLOSED,
                MobileTaskStatus::STATUS_TO_ASSIGN,
                MobileTaskStatus::STATUS_NO_BEGIN,
                MobileTaskStatus::STATUS_IN_PROGRESS,
                MobileTaskStatus::STATUS_PAUSED,
            ]);
    }

    /**
     * 更改任务预计交付日期：总任务负责人是当前登录用户
     * @param User $user
     * @param MobileTask $task
     * @return bool
     */
    public function expirationDate(User $user, MobileTask $task)
    {
        return $user->id == $task->main_principal_user_id &&
            !in_array($task->status, [
                MobileTaskStatus::STATUS_COMPLETED,
                MobileTaskStatus::STATUS_REVOCATION,
            ]);
    }

    /**
     * 审核任务
     * @param User $user
     * @param MobileTask $task
     * @return bool
     */
    public function verify(User $user, MobileTask $task)
    {
        if (empty($task->demand_id))
            return false;
        return $user->id == $task->main_principal_user_id &&
            $task->status == MobileTaskStatus::STATUS_TO_AUDIT;
    }

    /**
     * 更改审核
     * @param User $user
     * @param MobileTask $task
     * @return bool
     */
    public function verifyUpdate(User $user, MobileTask $task)
    {
        return $user->id == $task->main_principal_user_id &&
            in_array($task->status, [
                MobileTaskStatus::STATUS_CLOSED,
                MobileTaskStatus::STATUS_TO_ASSIGN,
                MobileTaskStatus::STATUS_NO_BEGIN,
                MobileTaskStatus::STATUS_IN_PROGRESS,
                MobileTaskStatus::STATUS_SUBMIT,
                MobileTaskStatus::STATUS_PAUSED,
            ]);
    }

    /**
     * 编辑
     * @param User $user
     * @param MobileTask $task
     * @return bool
     */
    public function update(User $user, MobileTask $task)
    {
        return empty($task->demand_id) && $user->id == $task->promulgator_id &&
            in_array($task->status, [
                MobileTaskStatus::STATUS_TO_AUDIT,
                MobileTaskStatus::STATUS_CLOSED,
                MobileTaskStatus::STATUS_TO_ASSIGN,
                MobileTaskStatus::STATUS_NO_BEGIN,
                MobileTaskStatus::STATUS_IN_PROGRESS,
                MobileTaskStatus::STATUS_SUBMIT,
                MobileTaskStatus::STATUS_PAUSED,
            ]);
    }
}
