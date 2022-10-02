<?php

namespace App\Traits\Task;

trait TaskNumberTrait
{
    public static function findAvailableTaskNumber()
    {
        // 任务编号（设计10，开发20，测试30）环节代码+YY+MM+0001（四位流水号）；例如设计1019110001
        $prefix = static::TASK_PREFIX . date('ym');
        for ($i = 0; $i < 10; $i++) {
            $lastTask = static::query()->where('created_at', '>=', date('Y-m-01 00:00:00'))->orderBy('id', 'desc')->first();
            if ($lastTask) {
                $lastNo = substr($lastTask->number, -4);
                $no = $prefix . str_pad((intval($lastNo) + 1), 4, '0', STR_PAD_LEFT);
            } else {
                $no = $prefix . '0001';
            }
            // 判断编号是否存在
            if (!static::query()->where('number', $no)->exists()) {
                return $no;
            }
        }
        logger()->warning('生成任务编号失败');
        return false;
    }

    // 子任务编号，总任务编号-1；例如设计1019110001-1
    public function findSubTaskNumber($isDesignSubTask = false)
    {
        for ($i = 0; $i < 10; $i++) {
            if ($isDesignSubTask) {
                $part = $this->part;
                $count = static::query()->where('part_id', $this->part_id)->count();
                $no = $part->number . '-' . ($count + 1);
            } else {
                $task = $this->task;
                $count = static::query()->where('task_id', $this->task_id)->count();
                $no = $task->number . '-' . ($count + 1);
            }

            // 判断编号是否存在
            if (!static::query()->where('number', $no)->exists()) {
                return $no;
            }
        }
        logger()->warning('生成子任务编号失败');
        return false;
    }
}
