<?php

namespace App\Enums\ProjectManage\Releases;

final class SubTaskReleaseType
{
    // 发布类型：0：跟随版本发布；1：hotfix上线；2：无需发布
    public const FOLLOW_VERSION = 0;
    public const HOTFIX = 1;
    public const NO_PUBLISH = 2;
}
