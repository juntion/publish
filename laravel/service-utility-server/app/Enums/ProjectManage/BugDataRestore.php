<?php

namespace App\Enums\ProjectManage;

final class BugDataRestore
{
    // 数据修复情况 1：未修复；2：已修复；3：无需程序修复；4：程序无法修复
    const NO_RESTORE = 1;
    const RESTORE_COMPLETED = 2;
    const NO_PROGRAM_RESTORE = 3;
    const PROGRAM_CANNOT_RESTORE = 4;

    public static function getDesc($dataRestore)
    {
        switch ($dataRestore) {
            case self::NO_RESTORE:
                return '未修复';
            case self::RESTORE_COMPLETED:
                return '已修复';
            case self::NO_PROGRAM_RESTORE:
                return '无需程序修复';
            case self::PROGRAM_CANNOT_RESTORE:
                return '程序无法修复';
            default:
                return '';
        }
    }
}
