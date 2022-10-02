<?php

namespace App\Enums\ProjectManage\Releases;

final class ReleaseProductStatus
{
    // 状态：0:关闭；1:开启
    const OFF = 0;
    const ON = 1;

    public static function getStatusDesc($status)
    {
        switch ($status) {
            case self::OFF:
                return '已关闭';
            case self::ON:
                return '开启中';
            default:
                return '';
        }
    }
}
