<?php

namespace App\ProjectManage\Models\Policies;

use App\Enums\ProjectManage\DesignTaskReview;
use App\Enums\ProjectManage\DesignTaskStatus;
use App\Models\User;
use App\ProjectManage\Models\DesignPart;
use App\ProjectManage\Models\DesignTask;

class DesignTaskPolicy
{
    /**
     * 审核: 设计负责人
     * @param User $user
     * @param DesignTask $task
     * @return bool
     */
    public function verify(User $user, DesignTask $task)
    {
        return $user->id == $task->principal_user_id &&
            in_array($task->status, [
                DesignTaskStatus::STATUS_CLOSED,
                DesignTaskStatus::STATUS_TO_AUDIT,
            ]);
    }

    /**
     * 更改设计环节: 设计负责人
     * @param User $user
     * @param DesignTask $task
     * @return bool
     */
    public function sequence(User $user, DesignTask $task)
    {
        $hasDemand = !empty($task->demand_id);
        return $user->id == $task->principal_user_id &&
            in_array($task->status, [
                DesignTaskStatus::STATUS_TO_ASSIGN,
                DesignTaskStatus::STATUS_NO_BEGIN,
                DesignTaskStatus::STATUS_IN_PROGRESS,
                DesignTaskStatus::STATUS_SUBMIT,
            ]);
    }

    /**
     * 设计走查: 该总任务下视觉或交互角色环节的负责人和跟进人
     * @param User $user
     * @param DesignTask $task
     * @return bool
     */
    public function review(User $user, DesignTask $task)
    {
        return in_array($user->id, $task->canReviewUsers()) &&
            in_array($task->review, [DesignTaskReview::REVIEW_WAIT, DesignTaskReview::REVIEW_TO_CONFIRM]) &&
            $task->status == DesignTaskStatus::STATUS_COMPLETED;
    }

    /**
     * 设置优先级：任务发布人或总任务负责人
     * @param User $user
     * @param DesignTask $task
     * @return bool
     */
    public function priority(User $user, DesignTask $task)
    {
        return in_array($user->id, [$task->promulgator_id, $task->principal_user_id]) &&
            !in_array($task->status, [
                DesignTaskStatus::STATUS_COMPLETED,
                DesignTaskStatus::STATUS_REVOCATION,
            ]);
    }

    /**
     * 更改设计总任务负责人：总任务负责人
     * @param User $user
     * @param DesignTask $task
     * @return bool
     */
    public function principal(User $user, DesignTask $task)
    {
        return $user->id == $task->principal_user_id &&
            in_array($task->status, [
                DesignTaskStatus::STATUS_CLOSED,
                DesignTaskStatus::STATUS_TO_AUDIT,
                DesignTaskStatus::STATUS_TO_ASSIGN,
            ]);
    }

    /**
     * 更改任务预计交付日期：总任务负责人是当前登录用户
     * @param User $user
     * @param DesignTask $task
     * @return bool
     */
    public function expirationDate(User $user, DesignTask $task)
    {
        return $user->id == $task->principal_user_id &&
            !in_array($task->status, [
                DesignTaskStatus::STATUS_COMPLETED,
                DesignTaskStatus::STATUS_REVOCATION,
            ]);
    }

    /**
     * 编辑
     * @param User $user
     * @param DesignTask $task
     */
    public function update(User $user, DesignTask $task)
    {
        return empty($task->demand_id) && $user->id == $task->promulgator_id &&
            in_array($task->status, [
                DesignTaskStatus::STATUS_TO_AUDIT,
                DesignTaskStatus::STATUS_TO_ASSIGN,
                DesignTaskStatus::STATUS_NO_BEGIN,
                DesignTaskStatus::STATUS_IN_PROGRESS,
                DesignTaskStatus::STATUS_SUBMIT,
                DesignTaskStatus::STATUS_PAUSED,
            ]);
    }
}
