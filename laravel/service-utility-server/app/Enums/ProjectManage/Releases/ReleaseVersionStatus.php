<?php

namespace App\Enums\ProjectManage\Releases;

final class ReleaseVersionStatus
{
    // 状态：1：待发布测试，2：版本测试中；3：已发布上线
    const TO_TEST = 1;
    const IN_TEST = 2;
    const ONLINE = 3;

    public static function getStatusDesc($status)
    {
        switch ($status) {
            case self::TO_TEST:
                return '待发布测试';
            case self::IN_TEST:
                return '版本测试中';
            case self::ONLINE:
                return '已发布上线';
            default:
                return '';
        }
    }
}
