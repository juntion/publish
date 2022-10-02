<?php

namespace App\Enums\ProjectManage;

use BenSampo\Enum\Enum;

final class DesignTaskStatus extends Enum
{
    // 状态；0：关闭中；1：待审核；2：待指派；3：未开始；4：进行中；5：已提交；6：已完成；7：已暂停；8：已撤销；
    const STATUS_CLOSED = 0;
    const STATUS_TO_AUDIT = 1;
    const STATUS_TO_ASSIGN = 2;
    const STATUS_NO_BEGIN = 3;
    const STATUS_IN_PROGRESS = 4;
    const STATUS_SUBMIT = 5;
    const STATUS_COMPLETED = 6;
    const STATUS_PAUSED = 7;
    const STATUS_REVOCATION = 8;

    const REVIEW_NOT_NEED = 0; // 无需设计走查
    const REVIEW_NEED = 1; // 需要设计走查
    const REVIEW_NO_BEGIN = 2; // 待走查
    const REVIEW_TO_CONFIRM= 3; // 待确认

    /**
     * @param $status
     * @return string
     */
    public static function getStatusDesc($status)
    {
        switch ($status) {
            case self::STATUS_CLOSED:
                return '等待中';
            case self::STATUS_TO_AUDIT:
                return '待审核';
            case self::STATUS_TO_ASSIGN:
                return '待指派';
            case self::STATUS_NO_BEGIN:
                return '未开始';
            case self::STATUS_IN_PROGRESS:
                return '进行中';
            case self::STATUS_SUBMIT:
                return '已提交';
            case self::STATUS_COMPLETED:
                return '已完成';
            case self::STATUS_PAUSED:
                return '已暂停';
            case self::STATUS_REVOCATION:
                return '已撤销';
            default:
                return '';
        }
    }

}
