<?php

namespace App\Enums\ProjectManage;

final class OperationPlatform
{
    // 操作平台 1：FS平台(原前台PC端)；2：后台PC端；3：PDA；4：APP；5：Community中文；6：Community英文；7：Arms
    const FRONTEND_PC = 1;
    const BACKEND_PC = 2;
    const PDA = 3;
    const APP = 4;
    const COMMUNITY_CN = 5;
    const COMMUNITY_EN = 6;
    const ARMS = 7;

    public static function getDesc(int $platform)
    {
        switch ($platform) {
            case self::FRONTEND_PC:
                return 'FS平台';
            case self::BACKEND_PC:
                return '后台PC端';
            case self::PDA:
                return 'PDA';
            case self::APP:
                return 'APP';
            case self::COMMUNITY_CN:
                return 'Community中文';
            case self::COMMUNITY_EN:
                return 'Community英文';
            case self::ARMS:
                return 'Arms';
            default:
                return '';
        }
    }
}
