<?php

namespace App\Enums\ProjectManage\Releases;

final class SubTaskReleaseStatus
{
    // 发布状态：1：未发布测试；2：已发布测试
    public const NO_RELEASE_TEST = 1;
    public const RELEASED_TEST = 2;
}
