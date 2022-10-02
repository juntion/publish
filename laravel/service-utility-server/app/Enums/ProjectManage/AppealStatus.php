<?php

namespace App\Enums\ProjectManage;

use BenSampo\Enum\Enum;

final class AppealStatus extends Enum
{
    // 诉求状态
    // 0：待受理；1：跟进中；2：排期中；3：立项待审核；4：已立项；5：已完成；6：已驳回；7：已撤销；8：待分配
    const STATUS_TO_ACCEPT = 0;
    const STATUS_FOLLOWING = 1;
    const STATUS_SCHEDULING = 2;
    const STATUS_PENDING_REVIEW = 3;
    const STATUS_HAS_PROJECT = 4;
    const STATUS_COMPLETED = 5;
    const STATUS_REJECTED = 6;
    const STATUS_REVOCATION = 7;
    const STATUS_TO_DISTRIBUTION = 8;

    /**
     * 获取诉求状态描述
     * @param int $status
     * @return string
     */
    public static function getStatusDesc(int $status)
    {
        switch ($status) {
            case self::STATUS_TO_ACCEPT:
                return '待受理';
            case  self::STATUS_FOLLOWING:
                return '跟进中';
            case  self::STATUS_SCHEDULING:
                return '排期中';
            case self::STATUS_PENDING_REVIEW:
                return '立项待审核';
            case self::STATUS_HAS_PROJECT:
                return '已立项';
            case self::STATUS_COMPLETED:
                return '已完成';
            case self::STATUS_REJECTED:
                return '已驳回';
            case  self::STATUS_REVOCATION:
                return '已撤销';
            case self::STATUS_TO_DISTRIBUTION:
                return '待分配';
            default:
                return '';
        }
    }

}
