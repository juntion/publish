<?php

namespace App\Enums\ProjectManage;

final class AppealType
{
    // 诉求类型
    // 1：规则调整；2：新增功能；3：迭代建议；4：数据提取；5：Bug修复；
    const TYPE_RULE_ADJUST = 1;
    const TYPE_ADD_FEATURE = 2;
    const TYPE_ITERATIVE_ADVICE = 3;
    const TYPE_DATA_EXTRACTION = 4;
    const TYPE_BUG_FIX = 5;

    public static function getTypeDesc($type): string
    {
        switch ($type) {
            case self::TYPE_RULE_ADJUST:
                return '规则调整';
            case self::TYPE_ADD_FEATURE:
                return '新增功能';
            case self::TYPE_ITERATIVE_ADVICE:
                return '迭代建议';
            case self::TYPE_DATA_EXTRACTION:
                return '数据提取';
            case self::TYPE_BUG_FIX:
                return 'Bug修复';
            default:
                return '';
        }
    }
}
