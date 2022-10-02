<?php

namespace App\Enums\ProjectManage\Releases;

use App\ProjectManage\Models\ReleaseProduct;

final class ReleaseCycle
{
    // 发布周期：1:每周；2：每两周；3：每月
    const RELEASE_TYPE_WEEKLY = 1;
    const RELEASE_TYPE_TWO_WEEKS = 2;
    const RELEASE_TYPE_MONTHLY = 3;

    const WEEK_DAY = [
        0 => '星期日',
        1 => '星期一',
        2 => '星期二',
        3 => '星期三',
        4 => '星期四',
        5 => '星期五',
        6 => '星期六',
        7 => '星期日',
    ];

    public static function getReleaseTypeDesc($releaseType)
    {
        switch ($releaseType) {
            case self::RELEASE_TYPE_WEEKLY:
                return '每周';
            case self::RELEASE_TYPE_TWO_WEEKS:
                return '每两周';
            case self::RELEASE_TYPE_MONTHLY:
                return '每月';
            default:
                return '';
        }
    }

    /**
     * @param ReleaseProduct $product
     * @return string
     */
    public static function getReleaseDayDesc(ReleaseProduct $product)
    {
        if ($product->release_type == self::RELEASE_TYPE_MONTHLY) {
            return $product->release_day . '日';
        }
        return self::WEEK_DAY[$product->release_day] ?? '';
    }

    public static function getReleaseCycleDesc(ReleaseProduct $product)
    {
        return self::getReleaseTypeDesc($product->release_type) . ' ' . self::getReleaseDayDesc($product);
    }
}
