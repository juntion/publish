<?php


namespace App\Enums\ProjectManage;


use BenSampo\Enum\Enum;

final class TestTaskStatus extends Enum
{
    // 状态；0：关闭中；1：待指派；2：待测试；3：测试中；4：已完成；；5：已暂停；6：已撤销；7：已提交；8：待发布；9：待审核
    const STATUS_CLOSED = 0;
    const STATUS_TO_ASSIGN = 1;
    const STATUS_NO_BEGIN = 2;
    const STATUS_IN_TEST = 3;
    const STATUS_COMPLETED = 4;
    const STATUS_PAUSED = 5;
    const STATUS_REVOCATION = 6;
    const STATUS_SUBMIT = 7;
    const STATUS_TO_RELEASE = 8;
    const STATUS_TO_AUDIT = 9;

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
            case self::STATUS_TO_AUDIT:
                return '待审核';
            default:
                return '';
        }
    }
}
