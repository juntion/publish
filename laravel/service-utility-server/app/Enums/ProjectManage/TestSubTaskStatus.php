<?php

namespace App\Enums\ProjectManage;

use BenSampo\Enum\Enum;

final class TestSubTaskStatus extends Enum
{
    // 状态；0：待测试；1：测试中；2：已完成；3：已暂停；4：已撤销；5：已提交；6:待发布；7：关闭中
    const STATUS_NO_BEGIN = 0;
    const STATUS_IN_TEST = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_PAUSED = 3;
    const STATUS_REVOCATION = 4;
    const STATUS_SUBMIT = 5;
    const STATUS_TO_RELEASE = 6;
    const STATUS_CLOSED = 7;

    /**
     * @param $status
     * @return string
     */
    public static function getStatusDesc($status)
    {
        switch ($status) {
            case self::STATUS_NO_BEGIN:
                return '待测试';
            case self::STATUS_IN_TEST:
                return '测试中';
            case self::STATUS_COMPLETED:
                return '已完成';
            case self::STATUS_PAUSED:
                return '已暂停';
            case self::STATUS_REVOCATION:
                return '已撤销';
            case self::STATUS_SUBMIT:
                return '已提交';
            case self::STATUS_TO_RELEASE:
                return '待发布';
            case self::STATUS_CLOSED:
                return '等待中';
            default:
                return '';
        }
    }
}
