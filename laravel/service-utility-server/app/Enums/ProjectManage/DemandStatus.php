<?php


namespace App\Enums\ProjectManage;


final class DemandStatus
{
    // 状态；0：待审核；1：审核驳回；2：待推送；3：待指派；4：未处理；5：研发中；6：已提交；7：待测试；8：测试中；9：已完成；10：已暂停；11：已撤销；
    const STATUS_TO_ACCEPT = 0;
    const STATUS_REJECTED = 1;
    const STATUS_TO_PUSH = 2;
    const STATUS_TO_ASSIGN = 3;
    const STATUS_NO_BEGIN = 4;
    const STATUS_IN_PROGRESS = 5;
    const STATUS_SUBMIT = 6;
    const STATUS_TO_TEST = 7;
    const STATUS_IN_TEST = 8;
    const STATUS_COMPLETED = 9;
    const STATUS_PAUSED = 10;
    const STATUS_REVOCATION = 11;

    /**
     * @param $status
     * @return string
     */
    public static function getStatusDesc($status)
    {
        switch ($status){
            case self::STATUS_TO_ACCEPT:
                return "待审核";
            case self::STATUS_REJECTED:
                return "审核驳回";
            case self::STATUS_TO_PUSH:
                return "待推送";
            case self::STATUS_TO_ASSIGN:
                return "待指派";
            case self::STATUS_NO_BEGIN:
                return "未处理";
            case self::STATUS_IN_PROGRESS:
                return "研发中";
            case self::STATUS_SUBMIT:
                return "已提交";
            case self::STATUS_TO_TEST:
                return "待测试";
            case self::STATUS_IN_TEST:
                return "测试中";
            case self::STATUS_COMPLETED:
                return "已完成";
            case self::STATUS_PAUSED:
                return "已暂停";
            case self::STATUS_REVOCATION:
                return "已撤销";
            default:
                return "未知状态";

        }
    }
}
