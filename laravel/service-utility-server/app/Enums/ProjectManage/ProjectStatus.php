<?php


namespace App\Enums\ProjectManage;


final class ProjectStatus
{
    // 项目状态；0：关闭中；1：开启中；2：暂停中；3：已完成；4：已撤销；
    const STATUS_OFF = 0;
    const STATUS_ON = 1;
    const STATUS_PAUSED = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_REVOCATION = 4;

    public static function getStatusDesc($status)
    {
        switch ($status){
            case self::STATUS_OFF:
                return "关闭中";
            case self::STATUS_ON:
                return "开启中";
            case self::STATUS_PAUSED:
                return "暂停中";
            case self::STATUS_COMPLETED:
                return "已完成";
            case self::STATUS_REVOCATION:
                return "已撤销";
            default:
                return "未知状态";
        }
    }
}
