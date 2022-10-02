<?php

namespace App\Enums\ProjectManage;

final class DesignPartType
{
    // 环节类型；0：交互；1：视觉；2：美工；3：前端；4：移动端
    const INTERACTIVE = 0;
    const VISUAL = 1;
    const ARTIST = 2;
    const FRONT_END = 3;
    const MOBILE = 4;

    // 设计环节对应团队成员类型（用于确定环节的负责人）
    const partTypeTeamMemberMapping = [
        self::INTERACTIVE => TeamMemberType::TYPE_INTERACTIVE,
        self::VISUAL => TeamMemberType::TYPE_VISUAL,
        self::ARTIST => TeamMemberType::TYPE_ART,
        self::FRONT_END => TeamMemberType::TYPE_FRONTEND,
        self::MOBILE => TeamMemberType::TYPE_MOBILE,
    ];

    public static function getDesc($type): string
    {
        switch ($type) {
            case self::INTERACTIVE:
                return '交互';
            case self::VISUAL:
                return '视觉';
            case self::ARTIST:
                return '美工';
            case self::FRONT_END:
                return '前端';
            case self::MOBILE:
                return '移动端';
            default:
                return '';
        }
    }
}
