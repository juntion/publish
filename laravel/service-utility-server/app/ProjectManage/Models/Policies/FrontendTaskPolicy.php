<?php

namespace App\ProjectManage\Models\Policies;

use App\Enums\ProjectManage\Task\FrontendTaskStatus;
use App\Enums\ProjectManage\ProductStatus;
use App\Enums\ProjectManage\TeamType;
use App\Models\User;
use App\ProjectManage\Models\FrontendTask;

class FrontendTaskPolicy
{
    /**
     * 更改开发总任务负责人：必须有来源需求，产品维护的默认开发负责人是当前登录用户
     * @param User $user
     * @param FrontendTask $task
     * @return bool
     */
    public function setPrincipal(User $user, FrontendTask $task)
    {
        $demand = $task->demand;
        if (!$demand) {
            return false;
        }
        $product = $demand->products->where('type', ProductStatus::TypeProduct)->first();
        $team = $product->teams->where('type', TeamType::TYPE_FRONTEND)->where('is_default', 1)->first();
        $demand->products->each(function ($product) {
            unset($product->teams);
        });
        if (!$team) {
            return false;
        }
        return $user->id == $team->user_id &&
            in_array($task->status, [
                FrontendTaskStatus::STATUS_CLOSED,
                FrontendTaskStatus::STATUS_TO_ASSIGN,
            ]);
    }

    /**
     * 创建子任务：开发负责人
     * @param User $user
     * @param FrontendTask $task
     * @return bool
     */
    public function createSubTask(User $user, FrontendTask $task)
    {
        return $user->id == $task->principal_user_id &&
            in_array($task->status, [
                FrontendTaskStatus::STATUS_NO_BEGIN,
                FrontendTaskStatus::STATUS_IN_PROGRESS,
                FrontendTaskStatus::STATUS_SUBMIT,
            ]);
    }

    /**
     * 设置优先级：任务发布人或主负责人
     * @param User $user
     * @param FrontendTask $task
     * @return bool
     */
    public function priority(User $user, FrontendTask $task)
    {
        return in_array($user->id, [$task->promulgator_id, $task->main_principal_user_id]) &&
            !in_array($task->status, [
                FrontendTaskStatus::STATUS_COMPLETED,
                FrontendTaskStatus::STATUS_REVOCATION,
            ]);
    }

    /**
     * 指派任务处理人：开发负责人
     * @param User $user
     * @param FrontendTask $task
     * @return bool
     */
    public function setHandler(User $user, FrontendTask $task)
    {
        return $user->id == $task->principal_user_id &&
            in_array($task->status, [
                FrontendTaskStatus::STATUS_CLOSED,
                FrontendTaskStatus::STATUS_TO_ASSIGN,
                FrontendTaskStatus::STATUS_NO_BEGIN,
                FrontendTaskStatus::STATUS_IN_PROGRESS,
                FrontendTaskStatus::STATUS_PAUSED,
            ]);
    }

    /**
     * 更改任务预计交付日期：总任务负责人是当前登录用户
     * @param User $user
     * @param FrontendTask $task
     * @return bool
     */
    public function expirationDate(User $user, FrontendTask $task)
    {
        return $user->id == $task->main_principal_user_id &&
            !in_array($task->status, [
                FrontendTaskStatus::STATUS_COMPLETED,
                FrontendTaskStatus::STATUS_REVOCATION,
            ]);
    }

    /**
     * 审核任务
     * @param User $user
     * @param FrontendTask $task
     * @return bool
     */
    public function verify(User $user, FrontendTask $task)
    {
        if (empty($task->demand_id))
            return false;
        return $user->id == $task->main_principal_user_id &&
            $task->status == FrontendTaskStatus::STATUS_TO_AUDIT;
    }

    /**
     * 更改审核
     * @param User $user
     * @param FrontendTask $task
     * @return bool
     */
    public function verifyUpdate(User $user, FrontendTask $task)
    {
        return $user->id == $task->main_principal_user_id &&
            in_array($task->status, [
                FrontendTaskStatus::STATUS_CLOSED,
                FrontendTaskStatus::STATUS_TO_ASSIGN,
                FrontendTaskStatus::STATUS_NO_BEGIN,
                FrontendTaskStatus::STATUS_IN_PROGRESS,
                FrontendTaskStatus::STATUS_SUBMIT,
                FrontendTaskStatus::STATUS_PAUSED,
            ]);
    }

    /**
     * 编辑
     * @param User $user
     * @param FrontendTask $task
     * @return bool
     */
    public function update(User $user, FrontendTask $task)
    {
        return empty($task->demand_id) && $user->id == $task->promulgator_id &&
            in_array($task->status, [
                FrontendTaskStatus::STATUS_TO_AUDIT,
                FrontendTaskStatus::STATUS_CLOSED,
                FrontendTaskStatus::STATUS_TO_ASSIGN,
                FrontendTaskStatus::STATUS_NO_BEGIN,
                FrontendTaskStatus::STATUS_IN_PROGRESS,
                FrontendTaskStatus::STATUS_SUBMIT,
                FrontendTaskStatus::STATUS_PAUSED,
            ]);
    }
}
