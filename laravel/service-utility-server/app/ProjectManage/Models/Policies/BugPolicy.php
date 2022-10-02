<?php

namespace App\ProjectManage\Models\Policies;

use App\Enums\ProjectManage\BugExamineStatus;
use App\Enums\ProjectManage\BugStatus;
use App\Models\User;
use App\ProjectManage\Models\Bug;
use App\ProjectManage\Models\BugAccept;

/**
 * 原型地址：
 * https://delgjm.axshare.com/#id=xx2e8u&p=%E9%A6%96%E9%A1%B5%E5%85%B1%E7%94%A8%E6%98%BE%E7%A4%BA%E5%92%8C%E9%80%BB%E8%BE%91&g=1
 */
class BugPolicy
{
    /**
     * 编辑
     */
    public function update(User $user, Bug $bug)
    {
        if ($this->bugHasExaminePassed($bug)) {
            return false;
        }
        return $bug->promulgator_id == $user->id &&
            in_array($bug->status, [
                BugStatus::STATUS_TO_ASSIGN,
                BugStatus::STATUS_TO_ACCEPT,
                BugStatus::STATUS_SCHEDULING,
                BugStatus::STATUS_TO_FINANCIAL_EXAMINE,
                // BugStatus::STATUS_TO_INTERNAL_CONTROL_EXAMINE,
            ]) && !$this->bugHasRejectLabel($bug)
            && !$this->bugHasClosed($bug);
    }

    /**
     * 是否审批通过
     * @param Bug $bug
     * @return bool
     */
    protected function bugHasExaminePassed(Bug $bug)
    {
        return !empty($bug->erp_bug_id) ||
            in_array($bug->examine_status, [
                BugExamineStatus::FINANCIAL_EXAMINE_PASS,
                BugExamineStatus::INTERNAL_CONTROL_EXAMINE_PASS,
            ]);
    }

    /**
     * 撤销
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function revocation(User $user, Bug $bug)
    {
        if ($this->bugHasExaminePassed($bug)) {
            return false;
        }
        return $bug->promulgator_id == $user->id &&
            in_array($bug->status, [
                BugStatus::STATUS_TO_ASSIGN,
                BugStatus::STATUS_TO_ACCEPT,
                BugStatus::STATUS_SCHEDULING,
                BugStatus::STATUS_TO_FINANCIAL_EXAMINE,
                // BugStatus::STATUS_TO_INTERNAL_CONTROL_EXAMINE,
            ]) && !$this->bugHasRejectLabel($bug)
            && !$this->bugHasClosed($bug);
    }

    /**
     * 发布诉求
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function publishAppeal(User $user, Bug $bug)
    {
        return $bug->promulgator_id == $user->id &&
            (in_array($bug->status, [BugStatus::STATUS_COMPLETED, BugStatus::STATUS_NO_HANDLE]) || $this->bugHasRejectLabel($bug))
            && !$this->bugHasClosed($bug);
    }

    /**
     * 发布需求
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function publishDemand(User $user, Bug $bug)
    {
        $hasDemand = $bug->demands->isNotEmpty();
        return $bug->product_principal_id == $user->id && !$hasDemand &&
            (in_array($bug->status, [BugStatus::STATUS_COMPLETED, BugStatus::STATUS_NO_HANDLE]) || $this->bugHasRejectLabel($bug))
            && !$this->bugHasClosed($bug);
    }

    /**
     * 是否被驳回
     * @param Bug $bug
     * @return mixed
     */
    protected function bugHasRejectLabel(Bug $bug)
    {
        return $bug->labels->whereIn('name', ['财务审批驳回', '内控审批驳回'])->isNotEmpty();
    }

    /**
     * 是否被关闭
     * @param Bug $bug
     * @return mixed
     */
    protected function bugHasClosed(Bug $bug)
    {
        return $bug->labels->whereIn('name', ['Bug已关闭'])->isNotEmpty();
    }

    /**
     * 设置产品负责人
     * @param User $user
     * @param Bug $bug
     */
    public function productPrincipal(User $user, Bug $bug)
    {
        return $bug->product_principal_id == $user->id &&
            in_array($bug->status, [
                BugStatus::STATUS_TO_ASSIGN,
                BugStatus::STATUS_TO_ACCEPT,
                BugStatus::STATUS_IN_PROGRESS,
                BugStatus::STATUS_TO_REEXAMINE,
                BugStatus::STATUS_SCHEDULING,
                BugStatus::STATUS_COMPLETED,
                BugStatus::STATUS_NO_HANDLE,
                BugStatus::STATUS_TO_FINANCIAL_EXAMINE,
                BugStatus::STATUS_TO_INTERNAL_CONTROL_EXAMINE,
            ])
            && !$this->bugHasRejectLabel($bug)
            && !$this->bugHasClosed($bug);
    }

    /**
     * 设置测试负责人
     * @param User $user
     * @param Bug $bug
     */
    public function testPrincipal(User $user, Bug $bug)
    {
        return $bug->test_principal_id == $user->id &&
            in_array($bug->status, [
                BugStatus::STATUS_TO_ASSIGN,
                BugStatus::STATUS_TO_ACCEPT,
                BugStatus::STATUS_IN_PROGRESS,
                BugStatus::STATUS_TO_REEXAMINE,
                BugStatus::STATUS_SCHEDULING,
                BugStatus::STATUS_COMPLETED,
                BugStatus::STATUS_NO_HANDLE,
                BugStatus::STATUS_TO_FINANCIAL_EXAMINE,
                BugStatus::STATUS_TO_INTERNAL_CONTROL_EXAMINE,
            ])
            && !$this->bugHasRejectLabel($bug)
            && !$this->bugHasClosed($bug);
    }

    /**
     * 设置开发负责人
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function programPrincipal(User $user, Bug $bug)
    {
        return $bug->program_principal_id == $user->id &&
            in_array($bug->status, [
                BugStatus::STATUS_TO_ASSIGN,
                BugStatus::STATUS_TO_ACCEPT,
                BugStatus::STATUS_IN_PROGRESS,
                BugStatus::STATUS_SCHEDULING,
                BugStatus::STATUS_TO_FINANCIAL_EXAMINE,
                BugStatus::STATUS_TO_INTERNAL_CONTROL_EXAMINE,
            ])
            && !$this->bugHasRejectLabel($bug)
            && !$this->bugHasClosed($bug);
    }

    /**
     * 申请审批
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function applyExamine(User $user, Bug $bug)
    {
        $users[] = $bug->program_principal_id;
        $users[] = $bug->product_principal_id;
        /*$handlers = $bug->handlers->pluck('handler_id')->toArray();
        if (!empty($handlers)) {
            $users = array_merge($users, $handlers);
        }*/
        // 是被审批过
        $noExamined = $bug->labels->whereIn('name', ['财务审批通过', '财务审批驳回', '内控审批通过', '内控审批驳回',])->isEmpty();
        return in_array($user->id, $users) &&
            in_array($bug->status, [
                BugStatus::STATUS_TO_ASSIGN,
                BugStatus::STATUS_TO_ACCEPT,
                BugStatus::STATUS_SCHEDULING,
                BugStatus::STATUS_IN_PROGRESS,
            ]) && $noExamined && !$this->bugHasClosed($bug);
    }

    /**
     * 撤销审批申请
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function applyExamineCancel(User $user, Bug $bug)
    {
        $users[] = $bug->product_principal_id;
        $users[] = $bug->program_principal_id;
        return in_array($user->id, $users) &&
            in_array($bug->status, [BugStatus::STATUS_TO_FINANCIAL_EXAMINE, BugStatus::STATUS_TO_INTERNAL_CONTROL_EXAMINE])
            && !$this->bugHasClosed($bug);
    }

    /**
     * 分配跟进人
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function follow(User $user, Bug $bug)
    {
        return $user->id == $bug->program_principal_id &&
            in_array($bug->status, [
                BugStatus::STATUS_TO_ASSIGN,
                BugStatus::STATUS_TO_ACCEPT,
                BugStatus::STATUS_SCHEDULING,
            ])
            && !$this->bugHasClosed($bug);
    }

    /**
     * 财务审批
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function financeExamine(User $user, Bug $bug)
    {
        return $user->hasPermissionTo('pm.bugs.financeExamine') &&
            in_array($bug->status, [BugStatus::STATUS_TO_FINANCIAL_EXAMINE, BugStatus::STATUS_TO_INTERNAL_CONTROL_EXAMINE])
            && !$this->bugHasClosed($bug);
    }

    /**
     * 内控审批
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function internalControlExamine(User $user, Bug $bug)
    {
        return $user->hasPermissionTo('pm.bugs.internalControlExamine') &&
            $bug->status == BugStatus::STATUS_TO_INTERNAL_CONTROL_EXAMINE
            && !$this->bugHasClosed($bug);
    }

    /**
     * 补充信息
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function appendInfo(User $user, Bug $bug)
    {
        return $user->id == $bug->product_principal_id &&
            $bug->status != BugStatus::STATUS_REVOCATION &&
            !$this->bugHasClosed($bug);
    }

    /**
     * 关闭bug
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function close(User $user, Bug $bug)
    {
        return $user->id == $bug->product_principal_id &&
            (in_array($bug->status, [BugStatus::STATUS_COMPLETED, BugStatus::STATUS_NO_HANDLE]) || $this->bugHasRejectLabel($bug))
            && !$this->bugHasClosed($bug);
    }

    /**
     * 提交处理结果
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function submitHandleResult(User $user, Bug $bug)
    {
        $allowStatus = [
            BugStatus::STATUS_TO_ACCEPT,
            BugStatus::STATUS_IN_PROGRESS,
            BugStatus::STATUS_SCHEDULING,
        ];
        $handlers = $bug->handlers->pluck('handler_id')->toArray();

        return in_array($user->id, $handlers) &&
            in_array($bug->status, $allowStatus)
            && !$this->bugHasRejectLabel($bug)
            && !$this->bugHasClosed($bug);
    }

    /**
     * 程序负责人和跟进人
     * @param Bug $bug
     * @return mixed
     */
    protected function programPrincipalAndHandles(Bug $bug)
    {
        $handlers = $bug->handlers->pluck('handler_id');
        return $handlers->merge($bug->program_principal_id)->unique()->toArray();
    }

    /**
     * 撤销提交处理结果
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function submitHandleResultCancel(User $user, Bug $bug)
    {
        $users = $handlers = $bug->handlers->pluck('handler_id')->toArray();
        return in_array($user->id, $users) &&
            in_array($bug->status, [
                BugStatus::STATUS_TO_REEXAMINE,
            ])
            && !$this->bugHasClosed($bug);
    }

    /**
     * 更改提交信息
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function updateHandleResult(User $user, Bug $bug)
    {
        $users = $this->programPrincipalAndHandles($bug);
        $allowStatus = [
            BugStatus::STATUS_COMPLETED,
            BugStatus::STATUS_NO_HANDLE,
        ];
        return in_array($user->id, $users) &&
            in_array($bug->status, $allowStatus)
            && !$this->bugHasRejectLabel($bug)
            && !$this->bugHasClosed($bug);
    }

    /**
     * 复核
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function reexamine(User $user, Bug $bug)
    {
        return $user->id == $bug->program_principal_id &&
            $bug->status == BugStatus::STATUS_TO_REEXAMINE
            && !$this->bugHasClosed($bug);
    }

    /**
     * 是否已验收通过
     * @param Bug $bug
     * @param $type
     * @return bool
     */
    protected function hasAccepted(Bug $bug, $type)
    {
        return $bug->bugAccept->where('type', $type)->where('result', 1)->isNotEmpty();
    }

    /**
     * 发布人验收
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function acceptPromulgator(User $user, Bug $bug)
    {
        return $user->id == $bug->promulgator_id &&
            in_array($bug->status, [BugStatus::STATUS_COMPLETED, BugStatus::STATUS_NO_HANDLE])
            && !$this->bugHasClosed($bug)
            && !$this->bugHasRejectLabel($bug)
            && !$this->hasAccepted($bug, BugAccept::TYPE_PROMULGATOR);
    }

    /**
     * 测试验收
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function acceptTest(User $user, Bug $bug)
    {
        return $user->id == $bug->test_principal_id &&
            in_array($bug->status, [BugStatus::STATUS_COMPLETED, BugStatus::STATUS_NO_HANDLE])
            && !$this->bugHasClosed($bug)
            && !$this->bugHasRejectLabel($bug)
            && !$this->hasAccepted($bug, BugAccept::TYPE_TEST);
    }

    /**
     * 产品验收
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function acceptProduct(User $user, Bug $bug)
    {
        return $user->id == $bug->product_principal_id &&
            in_array($bug->status, [BugStatus::STATUS_COMPLETED, BugStatus::STATUS_NO_HANDLE])
            && !$this->bugHasClosed($bug)
            && !$this->bugHasRejectLabel($bug)
            && !$this->hasAccepted($bug, BugAccept::TYPE_PRODUCT);
    }

    /**
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function expirationDate(User $user, Bug $bug)
    {
        return $user->id == $bug->program_principal_id &&
            in_array($bug->status, [
                BugStatus::STATUS_TO_ASSIGN,
                BugStatus::STATUS_TO_ACCEPT,
                BugStatus::STATUS_IN_PROGRESS,
                BugStatus::STATUS_TO_REEXAMINE,
                BugStatus::STATUS_SCHEDULING,
                BugStatus::STATUS_TO_FINANCIAL_EXAMINE,
                BugStatus::STATUS_TO_INTERNAL_CONTROL_EXAMINE,
            ]) && !$this->bugHasRejectLabel($bug)
            && !$this->bugHasClosed($bug);
    }

    /**
     * 开始
     * @param User $user
     * @param Bug $bug
     * @return bool
     */
    public function start(User $user, Bug $bug)
    {
        $users = $bug->handlers->pluck('handler_id')->toArray();
        if (empty($users)) {
            $users[] = $bug->program_principal_id;
        }
        return in_array($user->id, $users) && in_array($bug->status, [
                BugStatus::STATUS_TO_ASSIGN, BugStatus::STATUS_TO_ACCEPT
            ])
            && !$this->bugHasClosed($bug);
    }
}
