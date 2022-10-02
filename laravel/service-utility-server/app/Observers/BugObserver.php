<?php

namespace App\Observers;

use App\Contracts\Rpc\BugRpcInterface;
use App\Enums\ProjectManage\BugExamineStatus;
use App\Enums\ProjectManage\BugStatus;
use App\Enums\WsGateway\WsNotificationType;
use App\Events\PM\Bug\BugCompleted;
use App\Events\PM\Bug\BugExamine;
use App\ProjectManage\Models\Bug;
use App\Support\WsGateway;
use Illuminate\Support\Str;

class BugObserver
{

    protected $bugRpc;

    public function __construct(BugRpcInterface $bugRpc)
    {
        $this->bugRpc = $bugRpc;
    }

    public function created(Bug $bug)
    {
        $bug->createStatusLog(null, $bug->status);

        // Bug 创建后提醒负责人
        // 接收人员：产品负责人/程序负责人/测试负责人
        $this->notifyPrincipal([
            $bug->product_principal_id,
            $bug->program_principal_id,
            $bug->test_principal_id,
        ]);
    }

    /**
     * 提醒负责人
     * @param array $users
     */
    protected function notifyPrincipal($users)
    {
        $data = [
            'type' => WsNotificationType::NOTIFICATION,
            'title' => 'pms有新bug提醒',
            'content' => '您有一个新的bug任务需要负责，注意前往pms中进行查看！',
        ];
        WsGateway::sendToUid($users, $data);
    }

    public function updated(Bug $bug)
    {
        if ($bug->isDirty('status')) {
            // 状态日志
            $bug->createStatusLog($bug->getOriginal('status'), $bug->status);

            $this->syncErpStatus($bug);

            // bug处理完了 通知提bug人员
            if (in_array($bug->status, [BugStatus::STATUS_COMPLETED, BugStatus::STATUS_NO_HANDLE])) {
                event(new BugCompleted($bug));
            }

            // bug需要审批
            if (in_array($bug->status, [BugStatus::STATUS_TO_FINANCIAL_EXAMINE, BugStatus::STATUS_TO_INTERNAL_CONTROL_EXAMINE])) {
                event(new BugExamine($bug));
            }

            // bug需要复核
            if ($bug->status == BugStatus::STATUS_TO_REEXAMINE) {
                $this->reexamineNotify($bug->program_principal_id);
            }
        }

        // 审批日志
        if ($bug->isDirty('examine_status')) {
            $bug->createExamineStatusLog($bug->getOriginal('examine_status'), $bug->examine_status);
            $bug->addLabel(BugExamineStatus::getDesc($bug->examine_status));
        }

        // 更改负责人，提醒新负责人
        if ($bug->isDirty('product_principal_id')) {
            $this->notifyPrincipal([$bug->product_principal_id]);
        }
        if ($bug->isDirty('program_principal_id')) {
            $this->notifyPrincipal([$bug->program_principal_id]);
        }
        if ($bug->isDirty('test_principal_id')) {
            $this->notifyPrincipal([$bug->test_principal_id]);
        }
    }


    /**
     * 同步ERP状态
     * @param $bug
     */
    protected function syncErpStatus($bug)
    {
        // 同步ERP状态
        if (empty($bug->erp_bug_number)) return;

        $erpStatus = null;
        if (in_array($bug->status, [
            BugStatus::STATUS_TO_ACCEPT,
            BugStatus::STATUS_TO_FINANCIAL_EXAMINE,
            BugStatus::STATUS_TO_INTERNAL_CONTROL_EXAMINE,
            BugStatus::STATUS_SCHEDULING,
            BugStatus::STATUS_IN_PROGRESS,
            BugStatus::STATUS_TO_REEXAMINE,
        ])) {
            $erpStatus = $this->isErpOldBug($bug->erp_bug_number) ? BugStatus::ERP_STATUS_ACCEPTING : BugStatus::NEW_ERP_STATUS_ACCEPTING;
        }
        if (in_array($bug->status, [
            BugStatus::STATUS_COMPLETED,
            BugStatus::STATUS_NO_HANDLE,
            BugStatus::STATUS_REVOCATION,
        ])) {
            $erpStatus = $this->isErpOldBug($bug->erp_bug_number) ? BugStatus::ERP_STATUS_HANDLED : BugStatus::NEW_ERP_STATUS_HANDLED;
        }
        if (!empty($erpStatus)) {
            $res = $this->bugRpc->syncStatus($bug->erp_bug_number, $erpStatus);
            if ($res['status'] != 'success') {
                logger()->error('bug同步ERP状态失败', [$bug->id]);
            }
        }
    }

    /**
     * erp bug旧的编号以S开头，新编号以B开头
     * @param $erpBugNumber
     * @return bool
     */
    protected function isErpOldBug($erpBugNumber): bool
    {
        if (empty($erpBugNumber)) return false;
        return Str::startsWith($erpBugNumber, 'S');
    }

    /**
     * 复核提醒
     * 接收人：程序负责人
     * @param $userId
     */
    protected function reexamineNotify($userId)
    {
        $data = [
            'type' => WsNotificationType::NOTIFICATION,
            'title' => 'pms有bug待复核提醒',
            'content' => '您负责的bug开发已提交处理结果，请及时前往pms进行复核！',
        ];
        WsGateway::sendToUid($userId, $data);
    }
}
