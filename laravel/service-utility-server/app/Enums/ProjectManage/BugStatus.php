<?php

namespace App\Enums\ProjectManage;

final class BugStatus
{
    // bug状态 0：待指派；1：待受理；2：处理中；3：待复核；4：排期中；5：已处理；6：不处理；7：已撤销；8：申请审批；9：财务待审批；10：内控待审批
    const STATUS_TO_ASSIGN = 0;
    const STATUS_TO_ACCEPT = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_TO_REEXAMINE = 3;
    const STATUS_SCHEDULING = 4;
    const STATUS_COMPLETED = 5;
    const STATUS_NO_HANDLE = 6;
    const STATUS_REVOCATION = 7;
    const STATUS_APPLY_EXAMINE = 8; // 废弃
    const STATUS_TO_FINANCIAL_EXAMINE = 9;
    const STATUS_TO_INTERNAL_CONTROL_EXAMINE = 10;

    public static function getStatusDesc(int $status)
    {
        switch ($status) {
            case self::STATUS_TO_ASSIGN:
                return '待指派';
            case self::STATUS_TO_ACCEPT:
                return '待受理';
            case self::STATUS_IN_PROGRESS:
                return '处理中';
            case self::STATUS_TO_REEXAMINE:
                return '待复核';
            case self::STATUS_SCHEDULING:
                return '排期中';
            case self::STATUS_COMPLETED:
                return '已处理';
            case self::STATUS_NO_HANDLE:
                return '不处理';
            case self::STATUS_REVOCATION:
                return '已撤销';
            case self::STATUS_TO_FINANCIAL_EXAMINE:
                return '财务待审批';
            case self::STATUS_TO_INTERNAL_CONTROL_EXAMINE:
                return '内控待审批';
            default:
                return '';
        }
    }

    // ERP bug 状态
    // 0未审核 1受理中 2已通过 3已处理 4已驳回 5申请审批
    const ERP_STATUS_TO_APPROVE = 0;
    const ERP_STATUS_ACCEPTING = 1;
    const ERP_STATUS_PASS = 2;
    const ERP_STATUS_HANDLED = 3;
    const ERP_STATUS_REJECT = 4;
    const ERP_STATUS_APPLY_APPROVE = 5;

    // new 2021年4月7日
    // 0未审核 1申请审批 2受理中 3已通过 4已处理 5已驳回
    const NEW_ERP_STATUS_TO_APPROVE = 0;
    const NEW_ERP_STATUS_APPLY_APPROVE = 1;
    const NEW_ERP_STATUS_ACCEPTING = 2;
    const NEW_ERP_STATUS_PASS = 3;
    const NEW_ERP_STATUS_HANDLED = 4;
    const NEW_ERP_STATUS_REJECT = 5;
}
