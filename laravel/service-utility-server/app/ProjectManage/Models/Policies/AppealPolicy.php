<?php

namespace App\ProjectManage\Models\Policies;

use App\Enums\ProjectManage\AppealStatus;
use App\Models\User;
use App\ProjectManage\Models\Appeal;

class AppealPolicy
{
    /**
     * 编辑：发布人
     * @param User $user
     * @param Appeal $appeal
     * @return bool
     */
    public function edit(User $user, Appeal $appeal)
    {
        return $user->id == $appeal->promulgator_id &&
            in_array($appeal->status, [
                AppealStatus::STATUS_TO_ACCEPT,
                AppealStatus::STATUS_FOLLOWING,
                AppealStatus::STATUS_SCHEDULING,
                AppealStatus::STATUS_TO_DISTRIBUTION,
            ]);
    }

    /**
     * 撤销诉求：发布人
     * @param User $user
     * @param Appeal $appeal
     * @return bool
     */
    public function revocation(User $user, Appeal $appeal)
    {
        return $user->id == $appeal->promulgator_id &&
            in_array($appeal->status, [
                AppealStatus::STATUS_TO_ACCEPT,
                AppealStatus::STATUS_FOLLOWING,
                AppealStatus::STATUS_SCHEDULING,
                AppealStatus::STATUS_TO_DISTRIBUTION,
            ]);
    }

    /**
     * 指派：产品负责人
     * @param User $user
     * @param Appeal $appeal
     * @return bool
     */
    public function follow(User $user, Appeal $appeal)
    {
        return $user->id == $appeal->principal_user_id &&
            in_array($appeal->status, [
                AppealStatus::STATUS_TO_ACCEPT,
                AppealStatus::STATUS_FOLLOWING,
                AppealStatus::STATUS_SCHEDULING,
                AppealStatus::STATUS_TO_DISTRIBUTION,
            ]);
    }

    /**
     * 认领诉求：所属产品线（产品或产品模块）中，绑定的产品负责人或产品成员
     * @param User $user
     * @param Appeal $appeal
     * @return bool
     */
    public function apply(User $user, Appeal $appeal)
    {
        return in_array($user->id, $appeal->canApplyUsers()) &&
            (!$appeal->follower_id) &&
            $appeal->status == AppealStatus::STATUS_TO_DISTRIBUTION;
    }

    /**
     * 取消认领：诉求跟进人，负责人分配的诉求不允许取消认领
     * @param User $user
     * @param Appeal $appeal
     * @return bool
     */
    public function applyCancel(User $user, Appeal $appeal)
    {
        return $appeal->status == AppealStatus::STATUS_TO_ACCEPT &&
            $user->id == $appeal->follower_id &&
            $appeal->follow_type != 1;
    }

    /**
     * 删除：发布人
     * @param User $user
     * @param Appeal $appeal
     * @return bool
     */
    public function delete(User $user, Appeal $appeal)
    {
        return $user->id == $appeal->promulgator_id &&
            in_array($appeal->status, [
                AppealStatus::STATUS_TO_ACCEPT,
                AppealStatus::STATUS_SCHEDULING,
                AppealStatus::STATUS_TO_DISTRIBUTION,
            ]);
    }

    /**
     * 变更产品分类：诉求发布人、产品负责人或诉求跟进人
     * @param User $user
     * @param Appeal $appeal
     * @return bool
     */
    public function products(User $user, Appeal $appeal)
    {
        return in_array($user->id, [$appeal->promulgator_id, $appeal->principal_user_id, $appeal->follower_id]) &&
            in_array($appeal->status, [
                AppealStatus::STATUS_TO_ACCEPT,
                AppealStatus::STATUS_FOLLOWING,
                AppealStatus::STATUS_SCHEDULING,
                AppealStatus::STATUS_TO_DISTRIBUTION,
            ]);
    }

    /**
     * 更新审核：诉求跟进人
     * @param User $user
     * @param Appeal $appeal
     * @return bool
     */
    public function verify(User $user, Appeal $appeal)
    {
        return $user->id == $appeal->follower_id &&
            in_array($appeal->status, [
                AppealStatus::STATUS_TO_ACCEPT,
                AppealStatus::STATUS_FOLLOWING,
                AppealStatus::STATUS_SCHEDULING,
            ]);
    }

    /**
     * 拆解：产品负责人、诉求跟进人（已拆解的诉求不能再次拆解）
     * @param User $user
     * @param Appeal $appeal
     * @return bool
     */
    public function disassemble(User $user, Appeal $appeal)
    {
        return in_array($user->id, [$appeal->principal_user_id, $appeal->follower_id]) &&
            empty($appeal->origin_id) &&
            in_array($appeal->status, [
                AppealStatus::STATUS_TO_ACCEPT,
                AppealStatus::STATUS_FOLLOWING,
                AppealStatus::STATUS_SCHEDULING,
                AppealStatus::STATUS_TO_DISTRIBUTION,
            ]);
    }

    /**
     * 贴标签：产品负责人或诉求跟进人
     * @param User $user
     * @param Appeal $appeal
     * @return bool
     */
    public function labels(User $user, Appeal $appeal)
    {
        return in_array($user->id, [$appeal->principal_user_id, $appeal->follower_id]) &&
            in_array($appeal->status, [
                AppealStatus::STATUS_TO_ACCEPT,
                AppealStatus::STATUS_FOLLOWING,
                AppealStatus::STATUS_SCHEDULING,
                AppealStatus::STATUS_PENDING_REVIEW,
                AppealStatus::STATUS_HAS_PROJECT,
                AppealStatus::STATUS_COMPLETED,
                AppealStatus::STATUS_TO_DISTRIBUTION,
            ]);
    }

    /**
     * 删除诉求的标签：产品负责人或诉求跟进人
     * @param User $user
     * @param Appeal $appeal
     * @return bool
     */
    public function deleteLabel(User $user, Appeal $appeal)
    {
        return in_array($user->id, [$appeal->principal_user_id, $appeal->follower_id]) &&
            in_array($appeal->status, [
                AppealStatus::STATUS_TO_ACCEPT,
                AppealStatus::STATUS_FOLLOWING,
                AppealStatus::STATUS_SCHEDULING,
                AppealStatus::STATUS_PENDING_REVIEW,
                AppealStatus::STATUS_HAS_PROJECT,
                AppealStatus::STATUS_COMPLETED,
                AppealStatus::STATUS_TO_DISTRIBUTION,
            ]);
    }

    /**
     * 诉求（合并）立项：诉求跟进人
     * @param User $user
     * @param Appeal $appeal
     * @return bool
     */
    public function createDemand(User $user, Appeal $appeal)
    {
        return $user->id == $appeal->follower_id &&
            in_array($appeal->status, [
                AppealStatus::STATUS_TO_ACCEPT,
                AppealStatus::STATUS_FOLLOWING,
                AppealStatus::STATUS_SCHEDULING,
            ]);
    }

    /**
     * 取消立项：诉求跟进人
     * @param User $user
     * @param Appeal $appeal
     * @return bool
     */
    public function cancelDemand(User $user, Appeal $appeal)
    {
        return $user->id == $appeal->follower_id && $appeal->status == AppealStatus::STATUS_PENDING_REVIEW;
    }

    /**
     * @param User $user
     * @param Appeal $appeal
     * @return bool
     */
    public function setPrincipal(User $user, Appeal $appeal)
    {
        return $user->id == $appeal->principal_user_id &&
            in_array($appeal->status, [
                AppealStatus::STATUS_TO_ACCEPT,
                AppealStatus::STATUS_FOLLOWING,
                AppealStatus::STATUS_SCHEDULING,
                AppealStatus::STATUS_PENDING_REVIEW,
                AppealStatus::STATUS_TO_DISTRIBUTION,
            ]);
    }
}
