<?php

namespace App\Enums\ProjectManage;

final class DesignSubTaskStatus
{
    // 状态；0：未开始；1：进行中；2：已提交；3：已完成；4：已暂停；5：已撤销；6：关闭中
    const STATUS_NO_BEGIN = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_SUBMIT = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_PAUSED = 4;
    const STATUS_REVOCATION = 5;
    const STATUS_CLOSED = 6;

    /**
     * @param $status
     * @return string
     */
    public static function getStatusDesc($status)
    {
        switch ($status) {
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
            case self::STATUS_CLOSED:
                return '等待中';
            default:
                return '';
        }
    }

    // 完成类型：1：按时完成；2：提前完成；3：超时完成
    const FINISH_TYPE_ON_TIME = 1;
    const FINISH_TYPE_AHEAD = 2;
    const FINISH_TYPE_OVERTIME = 3;

    public static function getFinishTypeDesc($type)
    {
        switch ($type) {
            case self::FINISH_TYPE_ON_TIME:
                return '按时完成';
            case self::FINISH_TYPE_AHEAD:
                return '提前完成';
            case self::FINISH_TYPE_OVERTIME:
                return '超时完成';
            default:
                return '';
        }
    }
}
