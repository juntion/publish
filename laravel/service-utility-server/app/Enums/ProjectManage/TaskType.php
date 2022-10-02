<?php

namespace App\Enums\ProjectManage;

final class TaskType
{
    // 任务层级类型： 1：总任务；2：环节；3：子任务
    const TYPE_MAIN = 1;
    const TYPE_PART = 2;
    const TYPE_SUB_TASK = 3;

    // 任务类型：设计、开发、测试
    const TASK_TYPE_DESIGN = 'design';
    const TASK_TYPE_DEV = 'dev';
    const TASK_TYPE_TEST = 'test';
    const TASK_TYPE_FRONTEND = 'frontend';
    const TASK_TYPE_MOBILE = 'mobile';
}
