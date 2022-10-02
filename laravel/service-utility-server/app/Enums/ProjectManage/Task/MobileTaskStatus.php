<?php

namespace App\Enums\ProjectManage\Task;

final class MobileTaskStatus
{
    //状态；0：关闭中；1：待指派；2：未开始；3：进行中；4：已提交；5：已完成；6：已暂停；7：已撤销；8：待审核
    const STATUS_CLOSED = 0;
    const STATUS_TO_ASSIGN = 1;
    const STATUS_NO_BEGIN = 2;
    const STATUS_IN_PROGRESS = 3;
    const STATUS_SUBMIT = 4;
    const STATUS_COMPLETED = 5;
    const STATUS_PAUSED = 6;
    const STATUS_REVOCATION = 7;
    const STATUS_TO_AUDIT = 8;

    /**
     * @param $status
     * @return string
     */
    public static function getStatusDesc($status)
    {
        switch ($status) {
            case self::STATUS_CLOSED:
                return '等待中';
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
            case self::STATUS_TO_AUDIT:
                return '待审核';
            default:
                return '';
        }
    }
}
