<?php


namespace App\Enums\ProjectManage;


class DemandLinksGroup
{
    const GROUP_TEST = 0;
    const PRODUCT_TEST = 1;

    public static function getTestType($val)
    {
        switch ($val){
            case self::GROUP_TEST:
                return '测试团队参与';
            case self::PRODUCT_TEST:
                return '产品自测';
            default:
                return '未知';
        }
    }
}
