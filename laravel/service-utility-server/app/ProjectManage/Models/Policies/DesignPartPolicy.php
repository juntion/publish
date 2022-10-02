<?php

namespace App\ProjectManage\Models\Policies;

use App\Enums\ProjectManage\DesignPartStatus;
use App\Models\User;
use App\ProjectManage\Models\DesignPart;

class DesignPartPolicy
{
    /**
     * 指派：设计角色环节负责人
     * @param User $user
     * @param DesignPart $part
     * @return bool
     */
    public function setPartHandler(User $user, DesignPart $part)
    {
        return $user->id == $part->principal_user_id &&
            in_array($part->status, [
                DesignPartStatus::STATUS_CLOSED,
                DesignPartStatus::STATUS_TO_ASSIGN,
                DesignPartStatus::STATUS_NO_BEGIN,
                DesignPartStatus::STATUS_IN_PROGRESS,
                DesignPartStatus::STATUS_PAUSED,
            ]);
    }

    /**
     * 创建子任务：设计角色环节负责人
     * @param User $user
     * @param DesignPart $part
     * @return bool
     */
    public function createSubTask(User $user, DesignPart $part)
    {
        return $user->id == $part->principal_user_id &&
            in_array($part->status, [
                DesignPartStatus::STATUS_NO_BEGIN,
                DesignPartStatus::STATUS_IN_PROGRESS,
                DesignPartStatus::STATUS_SUBMIT,
            ]);
    }
}
