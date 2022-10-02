<?php

namespace Modules\Tag\Enums;

final class TagDataStatus
{
    // 状态；1：开启；2：禁用；
    const STATUS_ON = 1;
    const STATUS_OFF = 2;

    public static function getStatusDesc($status)
    {
        switch ($status) {
            case self::STATUS_ON:
                return '开启';
            case self::STATUS_OFF:
                return '关闭';
            default:
                return '';
        }
    }
}
