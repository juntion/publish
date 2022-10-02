<?php

namespace App\Enums\ProjectManage;

use BenSampo\Enum\Enum;

final class TeamMemberType extends Enum
{
    const TYPE_PRODUCT = 0; // 产品
    const TYPE_INTERACTIVE = 1;// 交互
    const TYPE_VISUAL = 2; // 视觉
    const TYPE_FRONTEND = 3; // 前端
    const TYPE_MOBILE = 4; // 移动端
    const TYPE_ART = 5; // 美工

}
