<?php

namespace App\Enums\ProjectManage;

final class BugExamineStatus
{
    // 审批状态 1：待财务审批；2：财务审批通过；3：财务审批驳回；4：待内控审批；5：内控审批通过；6：内控审批驳回
    const TO_FINANCIAL_EXAMINE = 1;
    const FINANCIAL_EXAMINE_PASS = 2;
    const FINANCIAL_EXAMINE_REJECTED = 3;
    const TO_INTERNAL_CONTROL_EXAMINE = 4;
    const INTERNAL_CONTROL_EXAMINE_PASS = 5;
    const INTERNAL_CONTROL_EXAMINE_REJECTED = 6;

    public static function getDesc($status)
    {
        if (is_null($status)) return '';

        switch ($status) {
            case self::TO_FINANCIAL_EXAMINE:
                return '待财务审批';
            case self::FINANCIAL_EXAMINE_PASS:
                return '财务审批通过';
            case self::FINANCIAL_EXAMINE_REJECTED:
                return '财务审批驳回';
            case self::TO_INTERNAL_CONTROL_EXAMINE:
                return '待内控审批';
            case self::INTERNAL_CONTROL_EXAMINE_PASS:
                return '内控审批通过';
            case self::INTERNAL_CONTROL_EXAMINE_REJECTED:
                return '内控审批驳回';
            default:
                return '';
        }
    }
}
