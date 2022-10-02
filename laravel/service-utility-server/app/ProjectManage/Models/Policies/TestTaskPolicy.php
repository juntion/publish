<?php

namespace App\ProjectManage\Models\Policies;

use App\Enums\ProjectManage\TestTaskStatus;
use App\Models\User;
use App\ProjectManage\Models\TestTask;

class TestTaskPolicy
{
    /**
     * 更改测试总任务负责人：测试负责人
     * @param User $user
     * @param TestTask $task
     * @return bool
     */
    public function setPrincipal(User $user, TestTask $task)
    {
        return $user->id == $task->main_principal_user_id &&
            in_array($task->status, [TestTaskStatus::STATUS_CLOSED, TestTaskStatus::STATUS_TO_ASSIGN]);
    }

    /**
     * 创建子任务：测试负责人
     * @param User $user
     * @param TestTask $task
     * @return bool
     */
    public function createSubTask(User $user, TestTask $task)
    {
        return $user->id == $task->principal_user_id &&
            in_array($task->status, [
                TestTaskStatus::STATUS_NO_BEGIN,
                TestTaskStatus::STATUS_TO_RELEASE,
                TestTaskStatus::STATUS_IN_TEST,
                TestTaskStatus::STATUS_SUBMIT,
            ]);
    }

    /**
     * 设置优先级：任务发布人或负责人
     * @param User $user
     * @param TestTask $task
     * @return bool
     */
    public function priority(User $user, TestTask $task)
    {
        return in_array($user->id, [$task->promulgator_id, $task->main_principal_user_id]) &&
            !in_array($task->status, [
                TestTaskStatus::STATUS_COMPLETED,
                TestTaskStatus::STATUS_REVOCATION,
            ]);
    }

    /**
     * 指派任务处理人：测试负责人
     * @param User $user
     * @param TestTask $task
     * @return bool
     */
    public function setHandler(User $user, TestTask $task)
    {
        return $user->id == $task->principal_user_id &&
            in_array($task->status, [
                TestTaskStatus::STATUS_CLOSED,
                TestTaskStatus::STATUS_TO_ASSIGN,
                TestTaskStatus::STATUS_NO_BEGIN,
                TestTaskStatus::STATUS_TO_RELEASE,
                TestTaskStatus::STATUS_IN_TEST,
                TestTaskStatus::STATUS_PAUSED,
            ]);
    }

    /**
     * 更改任务预计交付日期：总任务负责人是当前登录用户
     * @param User $user
     * @param TestTask $task
     * @return bool
     */
    public function expirationDate(User $user, TestTask $task)
    {
        return $user->id == $task->main_principal_user_id &&
            !in_array($task->status, [
                TestTaskStatus::STATUS_COMPLETED,
                TestTaskStatus::STATUS_REVOCATION,
            ]);
    }

    /**
     * 审核任务
     * @param User $user
     * @param TestTask $task
     * @return false
     */
    public function verify(User $user, TestTask $task)
    {
        if (empty($task->demand_id))
            return false;
        return $task->status == TestTaskStatus::STATUS_TO_AUDIT &&
            $user->id == $task->main_principal_user_id;
    }

    /**
     * 更改审核
     * @param User $user
     * @param TestTask $task
     * @return bool
     */
    public function verifyUpdate(User $user, TestTask $task)
    {
        return
            $user->id == $task->main_principal_user_id &&
            in_array($task->status, [
                TestTaskStatus::STATUS_CLOSED,
                TestTaskStatus::STATUS_TO_ASSIGN,
                TestTaskStatus::STATUS_NO_BEGIN,
                TestTaskStatus::STATUS_IN_TEST,
                TestTaskStatus::STATUS_PAUSED,
                TestTaskStatus::STATUS_SUBMIT,
                TestTaskStatus::STATUS_TO_RELEASE,
            ]);
    }

    /**
     * 编辑
     * @param User $user
     * @param TestTask $task
     * @return bool
     */
    public function update(User $user, TestTask $task)
    {
        return empty($task->demand_id) && $user->id == $task->promulgator_id &&
            in_array($task->status, [
                TestTaskStatus::STATUS_TO_AUDIT,
                TestTaskStatus::STATUS_CLOSED,
                TestTaskStatus::STATUS_TO_ASSIGN,
                TestTaskStatus::STATUS_NO_BEGIN,
                TestTaskStatus::STATUS_IN_TEST,
                TestTaskStatus::STATUS_PAUSED,
                TestTaskStatus::STATUS_SUBMIT,
                TestTaskStatus::STATUS_TO_RELEASE,
            ]);
    }
}
