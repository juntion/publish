<?php

namespace App\Enums\ProjectManage;

use BenSampo\Enum\Enum;

final class TeamType extends Enum
{
    public const TYPE_PRODUCT = 1;
    public const TYPE_DESIGN = 2;
    public const TYPE_DEVELOP = 3;
    public const TYPE_TEST = 4;
    public const TYPE_FRONTEND = 5;
    public const TYPE_MOBILE = 6;
}
