<?php

namespace App\ProjectManage\Models\Policies;

use App\Enums\ProjectManage\DemandStatus;
use App\Enums\ProjectManage\Releases\SubTaskReleaseStatus;
use App\Enums\ProjectManage\Task\MobileSubTaskStatus;
use App\Enums\ProjectManage\Releases\ReleaseVersionStatus;
use App\Enums\ProjectManage\Releases\SubTaskReleaseType;
use App\Models\User;
use App\ProjectManage\Models\MobileSubTask;

class MobileSubTaskPolicy
{
    /**
     * 开始：任务处理人
     * @param User $user
     * @param MobileSubTask $subTask
     * @return bool
     */
    public function start(User $user, MobileSubTask $subTask)
    {
        // 关联需求不为暂停状态
        $demand = $subTask->hasDemand;
        if ($demand && $demand->status == DemandStatus::STATUS_PAUSED) {
            return false;
        }
        return $user->id == $subTask->handler_id &&
            in_array($subTask->status, [MobileSubTaskStatus::STATUS_NO_BEGIN, MobileSubTaskStatus::STATUS_PAUSED]);
    }

    /**
     * 提交：任务处理人
     * @param User $user
     * @param MobileSubTask $subTask
     * @return bool
     */
    public function submit(User $user, MobileSubTask $subTask)
    {
        return $user->id == $subTask->handler_id &&
            $subTask->status == MobileSubTaskStatus::STATUS_IN_PROGRESS;
    }

    /**
     * 更新提交信息
     * @param User $user
     * @param MobileSubTask $subTask
     * @return bool
     */
    public function submitUpdate(User $user, MobileSubTask $subTask)
    {
        $task = $subTask->task;
        $users = [$task->principal_user_id, $subTask->handler_id];
        return in_array($user->id, $users) &&
            $subTask->status == MobileSubTaskStatus::STATUS_COMPLETED;
    }

    /**
     * 撤销提交：任务处理人
     * @param User $user
     * @param MobileSubTask $subTask
     * @return bool
     */
    public function submitCancel(User $user, MobileSubTask $subTask)
    {
        return $user->id == $subTask->handler_id &&
            $subTask->status == MobileSubTaskStatus::STATUS_SUBMIT;
    }

    /**
     * 暂停：开发负责人或任务处理人
     * @param User $user
     * @param MobileSubTask $subTask
     * @return bool
     */
    public function pause(User $user, MobileSubTask $subTask)
    {
        return $subTask->status == MobileSubTaskStatus::STATUS_IN_PROGRESS
            && in_array($user->id, $subTask->principalAndHandler());
    }

    /**
     * 撤销：开发负责人
     * @param User $user
     * @param MobileSubTask $subTask
     * @return bool
     */
    public function revocation(User $user, MobileSubTask $subTask)
    {
        $demand = $subTask->hasDemand;
        return $user->id == $subTask->task->principal_user_id &&
            ($subTask->is_main == 0 || !$demand) &&
            in_array($subTask->status, [
                MobileSubTaskStatus::STATUS_NO_BEGIN,
                MobileSubTaskStatus::STATUS_IN_PROGRESS,
                MobileSubTaskStatus::STATUS_PAUSED,
            ]);
    }

    /**
     * 确认完成：开发负责人
     * @param User $user
     * @param MobileSubTask $subTask
     * @return bool
     */
    public function complete(User $user, MobileSubTask $subTask)
    {
        return $user->id == $subTask->task->principal_user_id &&
            $subTask->status == MobileSubTaskStatus::STATUS_SUBMIT;
    }

    /**
     * 更改交付日期：总任务负责人
     * @param User $user
     * @param MobileSubTask $subTask
     * @return bool
     */
    public function expirationDate(User $user, MobileSubTask $subTask)
    {
        return $user->id == $subTask->task->principal_user_id &&
            in_array($subTask->status, [
                MobileSubTaskStatus::STATUS_NO_BEGIN,
                MobileSubTaskStatus::STATUS_IN_PROGRESS,
                MobileSubTaskStatus::STATUS_SUBMIT,
                MobileSubTaskStatus::STATUS_PAUSED,
            ]);
    }

    /**
     * 设置优先级：任务发布人或负责人
     * @param User $user
     * @param MobileSubTask $subTask
     * @return bool
     */
    public function priority(User $user, MobileSubTask $subTask)
    {
        $task = $subTask->task;
        $users = [$task->principal_user_id, $task->promulgator_id];
        return in_array($user->id, $users) &&
            in_array($subTask->status, [
                MobileSubTaskStatus::STATUS_NO_BEGIN,
                MobileSubTaskStatus::STATUS_IN_PROGRESS,
                MobileSubTaskStatus::STATUS_SUBMIT,
                MobileSubTaskStatus::STATUS_PAUSED,
            ]);
    }

    /**
     * 更改版本信息
     * @param User $user
     * @param MobileSubTask $subTask
     * @return bool
     */
    public function updateVersion(User $user, MobileSubTask $subTask)
    {
        $versionAllowed = true;
        if ($version = $subTask->version) {
            $versionAllowed = $version->status == ReleaseVersionStatus::TO_TEST;
        }
        return in_array($subTask->status, [MobileSubTaskStatus::STATUS_SUBMIT, MobileSubTaskStatus::STATUS_COMPLETED,])
            && $versionAllowed && $user->id == $subTask->handler_id
            && !in_array($subTask->release_type, [SubTaskReleaseType::HOTFIX, SubTaskReleaseType::NO_PUBLISH]);
    }

    /**
     * 版本管理员更改版本
     * @param User $user
     * @param MobileSubTask $subTask
     * @return bool
     */
    public function modifyVersion(User $user, MobileSubTask $subTask)
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
     * @param MobileSubTask $subTask
     * @return bool
     */
    public function confirmVersion(User $user, MobileSubTask $subTask)
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
     * @param MobileSubTask $subTask
     * @return bool
     */
    public function cancelConfirmVersion(User $user, MobileSubTask $subTask)
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
     * @param MobileSubTask $subTask
     * @return bool
     */
    public function releaseTest(User $user, MobileSubTask $subTask)
    {
        $version = $subTask->version;
        if (!$version) {
            return false;
        }
        return $subTask->release_status == SubTaskReleaseStatus::NO_RELEASE_TEST &&
            in_array($user->id, $version->adminIds());
    }
}
