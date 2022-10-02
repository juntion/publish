<?php

namespace App\ProjectManage\Models\Policies;

use App\Enums\ProjectManage\DemandStatus;
use App\Enums\ProjectManage\DevSubTaskStatus;
use App\Enums\ProjectManage\Releases\ReleaseVersionStatus;
use App\Enums\ProjectManage\Releases\SubTaskReleaseStatus;
use App\Enums\ProjectManage\Releases\SubTaskReleaseType;
use App\Models\User;
use App\ProjectManage\Models\DevSubTask;

class DevSubTaskPolicy
{
    /**
     * 开始：任务处理人
     * @param User $user
     * @param DevSubTask $subTask
     * @return bool
     */
    public function start(User $user, DevSubTask $subTask)
    {
        // 关联需求不为暂停状态
        $demand = $subTask->hasDemand;
        if ($demand && $demand->status == DemandStatus::STATUS_PAUSED) {
            return false;
        }
        return $user->id == $subTask->handler_id &&
            in_array($subTask->status, [DevSubTaskStatus::STATUS_NO_BEGIN, DevSubTaskStatus::STATUS_PAUSED]);
    }

    /**
     * 提交：任务处理人
     * @param User $user
     * @param DevSubTask $subTask
     * @return bool
     */
    public function submit(User $user, DevSubTask $subTask)
    {
        return $user->id == $subTask->handler_id &&
            $subTask->status == DevSubTaskStatus::STATUS_IN_PROGRESS;
    }

    /**
     * 更新提交信息
     * @param User $user
     * @param DevSubTask $subTask
     * @return bool
     */
    public function submitUpdate(User $user, DevSubTask $subTask)
    {
        $task = $subTask->task;
        $users = [$task->principal_user_id, $subTask->handler_id];
        return in_array($user->id, $users) &&
            $subTask->status == DevSubTaskStatus::STATUS_COMPLETED;
    }

    /**
     * 撤销提交：任务处理人
     * @param User $user
     * @param DevSubTask $subTask
     * @return bool
     */
    public function submitCancel(User $user, DevSubTask $subTask)
    {
        return $user->id == $subTask->handler_id &&
            $subTask->status == DevSubTaskStatus::STATUS_SUBMIT;
    }

    /**
     * 暂停：开发负责人或任务处理人
     * @param User $user
     * @param DevSubTask $subTask
     * @return bool
     */
    public function pause(User $user, DevSubTask $subTask)
    {
        return $subTask->status == DevSubTaskStatus::STATUS_IN_PROGRESS
            && in_array($user->id, $subTask->principalAndHandler());
    }

    /**
     * 撤销：开发负责人
     * @param User $user
     * @param DevSubTask $subTask
     * @return bool
     */
    public function revocation(User $user, DevSubTask $subTask)
    {
        $demand = $subTask->hasDemand;
        return $user->id == $subTask->task->principal_user_id &&
            ($subTask->is_main == 0 || !$demand) &&
            in_array($subTask->status, [
                DevSubTaskStatus::STATUS_NO_BEGIN,
                DevSubTaskStatus::STATUS_IN_PROGRESS,
                DevSubTaskStatus::STATUS_PAUSED,
            ]);
    }

    /**
     * 确认完成：开发负责人
     * @param User $user
     * @param DevSubTask $subTask
     * @return bool
     */
    public function complete(User $user, DevSubTask $subTask)
    {
        return $user->id == $subTask->task->principal_user_id &&
            $subTask->status == DevSubTaskStatus::STATUS_SUBMIT;
    }

    /**
     * 更改交付日期：总任务负责人
     * @param User $user
     * @param DevSubTask $subTask
     * @return bool
     */
    public function expirationDate(User $user, DevSubTask $subTask)
    {
        return $user->id == $subTask->task->principal_user_id &&
            in_array($subTask->status, [
                DevSubTaskStatus::STATUS_NO_BEGIN,
                DevSubTaskStatus::STATUS_IN_PROGRESS,
                DevSubTaskStatus::STATUS_SUBMIT,
                DevSubTaskStatus::STATUS_PAUSED,
            ]);
    }

    /**
     * 设置优先级：任务发布人或负责人
     * @param User $user
     * @param DevSubTask $subTask
     * @return bool
     */
    public function priority(User $user, DevSubTask $subTask)
    {
        $task = $subTask->task;
        $users = [$task->principal_user_id, $task->promulgator_id];
        return in_array($user->id, $users) &&
            in_array($subTask->status, [
                DevSubTaskStatus::STATUS_NO_BEGIN,
                DevSubTaskStatus::STATUS_IN_PROGRESS,
                DevSubTaskStatus::STATUS_SUBMIT,
                DevSubTaskStatus::STATUS_PAUSED,
            ]);
    }

    /**
     * 更改版本信息
     * @param User $user
     * @param DevSubTask $subTask
     * @return bool
     */
    public function updateVersion(User $user, DevSubTask $subTask)
    {
        $versionAllowed = true;
        if ($version = $subTask->version) {
            $versionAllowed = $version->status == ReleaseVersionStatus::TO_TEST;
        }
        return in_array($subTask->status, [DevSubTaskStatus::STATUS_SUBMIT, DevSubTaskStatus::STATUS_COMPLETED,])
            && $versionAllowed && $user->id == $subTask->handler_id
            && !in_array($subTask->release_type, [SubTaskReleaseType::HOTFIX, SubTaskReleaseType::NO_PUBLISH]);
    }

    /**
     * 版本管理员更改版本
     * @param User $user
     * @param DevSubTask $subTask
     * @return bool
     */
    public function modifyVersion(User $user, DevSubTask $subTask)
    {
        $version = $subTask->version;
        if (!$version) {
            return false;
        }
        return $version->status == ReleaseVersionStatus::IN_TEST &&
            in_array($user->id, $version->adminIds());
    }

    /**
     * 确认版本
     * @param User $user
     * @param DevSubTask $subTask
     * @return bool
     */
    public function confirmVersion(User $user, DevSubTask $subTask)
    {
        $version = $subTask->version;
        if (!$version) {
            return false;
        }
        if ($demand = $subTask->hasDemand) {
            $users[] = $demand->promulgator_id;
        } else {
            $users[] = $subTask->task->promulgator_id;
        }
        return in_array($user->id, $users) && $subTask->product_confirmed == 0 &&
            in_array($version->status, [ReleaseVersionStatus::IN_TEST, ReleaseVersionStatus::TO_TEST]);
    }

    /**
     * 取消确认版本
     * @param User $user
     * @param DevSubTask $subTask
     * @return bool
     */
    public function cancelConfirmVersion(User $user, DevSubTask $subTask)
    {
        $version = $subTask->version;
        if (!$version) {
            return false;
        }
        if ($demand = $subTask->hasDemand) {
            $users[] = $demand->promulgator_id;
        } else {
            $users[] = $subTask->task->promulgator_id;
        }
        return in_array($user->id, $users) && $subTask->product_confirmed == 1 &&
            in_array($version->status, [ReleaseVersionStatus::IN_TEST, ReleaseVersionStatus::TO_TEST]);
    }

    /**
     * 发布测试
     * @param User $user
     * @param DevSubTask $subTask
     * @return bool
     */
    public function releaseTest(User $user, DevSubTask $subTask): bool
    {
        $version = $subTask->version;
        if (!$version) {
            return false;
        }
        return $subTask->release_status == SubTaskReleaseStatus::NO_RELEASE_TEST &&
            in_array($user->id, $version->adminIds());
    }
}