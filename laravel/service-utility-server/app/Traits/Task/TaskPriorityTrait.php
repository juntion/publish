<?php

namespace App\Traits\Task;

trait TaskPriorityTrait
{
    public function getPriorityAttribute($val)
    {
        if ($val == 0) {
            return "";
        }
        return $val;
    }

    /**
     * 任务类型：设计、开发、测试
     * @return string
     */
    public function getTaskTypeAttribute()
    {
        return self::TASK_TYPE;
    }
}
