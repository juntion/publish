<?php

namespace App\ProjectManage\Models\Policies;

use App\Enums\ProjectManage\DemandStatus;
use App\Enums\ProjectManage\TestSubTaskStatus;
use App\Models\User;
use App\ProjectManage\Models\TestSubTask;

class TestSubTaskPolicy
{
    /**
     * 开始：任务处理人
     * @param User $user
     * @param TestSubTask $subTask
     * @return bool
     */
    public function start(User $user, TestSubTask $subTask)
    {
        // 关联需求不为暂停状态
        $demand = $subTask->hasDemand;
        if ($demand && $demand->status == DemandStatus::STATUS_PAUSED) {
            return false;
        }
        return $user->id == $subTask->handler_id &&
            in_array($subTask->status, [
                TestSubTaskStatus::STATUS_NO_BEGIN,
                TestSubTaskStatus::STATUS_PAUSED,
            ]);
    }

    /**
     * 提交：任务处理人
     * @param User $user
     * @param TestSubTask $subTask
     * @return bool
     */
    public function submit(User $user, TestSubTask $subTask)
    {
        return $user->id == $subTask->handler_id &&
            $subTask->status == TestSubTaskStatus::STATUS_IN_TEST;
    }

    /**
     * 更新提交
     * @param User $user
     * @param TestSubTask $subTask
     * @return bool
     */
    public function submitUpdate(User $user, TestSubTask $subTask)
    {
        $users = [
            $subTask->task->principal_user_id,
            $subTask->handler_id,
        ];
        return in_array($user->id, $users) &&
            $subTask->status == TestSubTaskStatus::STATUS_COMPLETED;
    }

    /**
     * 撤销提交：任务处理人
     * @param User $user
     * @param TestSubTask $subTask
     * @return bool
     */
    public function submitCancel(User $user, TestSubTask $subTask)
    {
        return $user->id == $subTask->handler_id &&
            $subTask->status == TestSubTaskStatus::STATUS_SUBMIT;
    }

    /**
     * 暂停：开发负责人或任务处理人
     * @param User $user
     * @param TestSubTask $subTask
     * @return bool
     */
    public function pause(User $user, TestSubTask $subTask)
    {
        return $subTask->status == TestSubTaskStatus::STATUS_IN_TEST
            && in_array($user->id, $subTask->principalAndHandler());
    }

    /**
     * 撤销：开发负责人
     * @param User $user
     * @param TestSubTask $subTask
     * @return bool
     */
    public function revocation(User $user, TestSubTask $subTask)
    {
        $demand = $subTask->hasDemand;
        return $user->id == $subTask->task->principal_user_id &&
            ($subTask->is_main == 0 || !$demand) &&
            in_array($subTask->status, [
                TestSubTaskStatus::STATUS_NO_BEGIN,
                TestSubTaskStatus::STATUS_IN_TEST,
                TestSubTaskStatus::STATUS_PAUSED,
                TestSubTaskStatus::STATUS_TO_RELEASE,
            ]);
    }

    /**
     * 确认完成：开发负责人
     * @param User $user
     * @param TestSubTask $subTask
     * @return bool
     */
    public function complete(User $user, TestSubTask $subTask)
    {
        return $user->id == $subTask->task->principal_user_id &&
            $subTask->status == TestSubTaskStatus::STATUS_SUBMIT;
    }

    /**
     * 更改交付日期：总任务负责人
     * @param User $user
     * @param TestSubTask $subTask
     * @return bool
     */
    public function expirationDate(User $user, TestSubTask $subTask)
    {
        return $user->id == $subTask->task->principal_user_id &&
            in_array($subTask->status, [
                TestSubTaskStatus::STATUS_NO_BEGIN,
                TestSubTaskStatus::STATUS_IN_TEST,
                TestSubTaskStatus::STATUS_PAUSED,
                TestSubTaskStatus::STATUS_SUBMIT,
                TestSubTaskStatus::STATUS_TO_RELEASE,
            ]);
    }

    /**
     * 设置优先级：任务发布人或负责人
     * @param User $user
     * @param TestSubTask $subTask
     * @return bool
     */
    public function priority(User $user, TestSubTask $subTask)
    {
        $task = $subTask->task;
        $users = [$task->principal_user_id, $task->promulgator_id];
        return in_array($user->id, $users) &&
            in_array($subTask->status, [
                TestSubTaskStatus::STATUS_NO_BEGIN,
                TestSubTaskStatus::STATUS_IN_TEST,
                TestSubTaskStatus::STATUS_SUBMIT,
                TestSubTaskStatus::STATUS_PAUSED,
                TestSubTaskStatus::STATUS_TO_RELEASE,
            ]);
    }
}
