<?php

namespace App\ProjectManage\Models\Policies;

use App\Enums\ProjectManage\DemandStatus;
use App\Enums\ProjectManage\DesignPartType;
use App\Enums\ProjectManage\DesignSubTaskStatus;
use App\Enums\ProjectManage\Releases\ReleaseVersionStatus;
use App\Enums\ProjectManage\Releases\SubTaskReleaseStatus;
use App\Enums\ProjectManage\Releases\SubTaskReleaseType;
use App\Models\User;
use App\ProjectManage\Models\DesignSubTask;

class DesignSubTaskPolicy
{
    /**
     * 开始：任务处理人
     * @param User $user
     * @param DesignSubTask $subTask
     * @return bool
     */
    public function start(User $user, DesignSubTask $subTask)
    {
        // 关联需求不为暂停状态
        $demand = $subTask->hasDemand;
        if ($demand && $demand->status == DemandStatus::STATUS_PAUSED) {
            return false;
        }
        return $user->id == $subTask->handler_id &&
            in_array($subTask->status, [
                DesignSubTaskStatus::STATUS_NO_BEGIN,
                DesignSubTaskStatus::STATUS_PAUSED,
            ]);
    }

    /**
     * 提交：任务处理人
     * @param User $user
     * @param DesignSubTask $subTask
     * @return bool
     */
    public function submit(User $user, DesignSubTask $subTask)
    {
        return $user->id == $subTask->handler_id &&
            $subTask->status == DesignSubTaskStatus::STATUS_IN_PROGRESS;
    }

    /**
     * 更新提交
     * @param User $user
     * @param DesignSubTask $subTask
     * @return bool
     */
    public function submitUpdate(User $user, DesignSubTask $subTask)
    {
        $users[] = $subTask->partPrincipal();
        $users[] = $subTask->handler_id;
        return in_array($user->id, $users) && $subTask->status == DesignSubTaskStatus::STATUS_COMPLETED;
    }

    /**
     * 撤销提交：任务处理人
     * @param User $user
     * @param DesignSubTask $subTask
     * @return bool
     */
    public function submitCancel(User $user, DesignSubTask $subTask)
    {
        return $user->id == $subTask->handler_id &&
            $subTask->status == DesignSubTaskStatus::STATUS_SUBMIT;
    }

    /**
     * 暂停：角色环节负责人或任务处理人
     * @param User $user
     * @param DesignSubTask $subTask
     * @return bool
     */
    public function pause(User $user, DesignSubTask $subTask)
    {
        return $subTask->status == DesignSubTaskStatus::STATUS_IN_PROGRESS &&
            in_array($user->id, $subTask->principalAndHandler());
    }

    /**
     * 撤销：角色环节负责人
     * @param User $user
     * @param DesignSubTask $subTask
     * @return bool
     */
    public function revocation(User $user, DesignSubTask $subTask)
    {
        $demand = $subTask->hasDemand;
        return $user->id == $subTask->partPrincipal() &&
            ($subTask->is_main == 0 || !$demand) &&
            in_array($subTask->status, [
                DesignSubTaskStatus::STATUS_NO_BEGIN,
                DesignSubTaskStatus::STATUS_IN_PROGRESS,
                DesignSubTaskStatus::STATUS_PAUSED,
            ]);
    }

    /**
     * 确认完成：角色环节负责人
     * @param User $user
     * @param DesignSubTask $subTask
     * @return bool
     */
    public function complete(User $user, DesignSubTask $subTask)
    {
        return $user->id == $subTask->partPrincipal() &&
            $subTask->status == DesignSubTaskStatus::STATUS_SUBMIT;
    }

    /**
     * 更改交付日期：总任务负责人或角色负责人
     * @param User $user
     * @param DesignSubTask $subTask
     * @return bool
     */
    public function expirationDate(User $user, DesignSubTask $subTask)
    {
        return in_array($user->id, $subTask->principals()) &&
            in_array($subTask->status, [
                DesignSubTaskStatus::STATUS_NO_BEGIN,
                DesignSubTaskStatus::STATUS_IN_PROGRESS,
                DesignSubTaskStatus::STATUS_SUBMIT,
                DesignSubTaskStatus::STATUS_PAUSED,
            ]);
    }

    /**
     * 设置优先级：角色负责人
     * @param User $user
     * @param DesignSubTask $subTask
     * @return bool
     */
    public function priority(User $user, DesignSubTask $subTask)
    {
        return $user->id == $subTask->partPrincipal() &&
            in_array($subTask->status, [
                DesignSubTaskStatus::STATUS_NO_BEGIN,
                DesignSubTaskStatus::STATUS_SUBMIT,
                DesignSubTaskStatus::STATUS_PAUSED,
            ]);
    }

    /**
     * 更新版本信息
     * @param User $user
     * @param DesignSubTask $subTask
     * @return bool
     */
    public function updateVersion(User $user, DesignSubTask $subTask)
    {
        if ($subTask->part->type != DesignPartType::MOBILE) {
            return false;
        }
        $versionAllowed = true;
        if ($version = $subTask->version) {
            $versionAllowed = $version->status == ReleaseVersionStatus::TO_TEST;
        }
        return in_array($subTask->status, [DesignSubTaskStatus::STATUS_SUBMIT, DesignSubTaskStatus::STATUS_COMPLETED,])
            && $versionAllowed && $user->id == $subTask->handler_id
            && !in_array($subTask->release_type, [SubTaskReleaseType::HOTFIX, SubTaskReleaseType::NO_PUBLISH]);
    }

    /**
     * 版本管理员更改版本
     * @param User $user
     * @param DesignSubTask $subTask
     * @return bool
     */
    public function modifyVersion(User $user, DesignSubTask $subTask)
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
     * @param DesignSubTask $subTask
     * @return bool
     */
    public function confirmVersion(User $user, DesignSubTask $subTask)
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
     * @param DesignSubTask $subTask
     * @return bool
     */
    public function cancelConfirmVersion(User $user, DesignSubTask $subTask)
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
     * @param DesignSubTask $subTask
     * @return bool
     */
    public function releaseTest(User $user, DesignSubTask $subTask)
    {
        $version = $subTask->version;
        if (!$version) {
            return false;
        }
        return $subTask->release_status == SubTaskReleaseStatus::NO_RELEASE_TEST &&
            in_array($user->id, $version->adminIds());
    }
}
