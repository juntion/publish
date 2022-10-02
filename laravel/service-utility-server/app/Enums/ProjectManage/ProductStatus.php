<?php

namespace App\Enums\ProjectManage;

use BenSampo\Enum\Enum;

final class ProductStatus extends Enum
{
    // 产品类型
    const TypeLine = 0;
    const TypeProduct = 1;
    const TypeModule = 2;
    const TypeCategory = 3;

    // 产品状态
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    /**
     * 获取产品状态描述
     * @param $status
     * @return string
     */
    public static function getStatusDescription($status)
    {
        switch ($status) {
            case self::STATUS_ON:
                return '开启中';
            case self::STATUS_OFF:
                return '关闭';
            default:
                return '';
        }
    }
}
