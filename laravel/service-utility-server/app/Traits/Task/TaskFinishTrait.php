<?php

namespace App\Traits\Task;

use App\Enums\ProjectManage\DesignSubTaskStatus;
use Carbon\Carbon;

trait TaskFinishTrait
{
    /**
     * 系统计算任务完成类型
     * @param $expirationDate
     * @return int
     */
    protected function shouldFinishType($expirationDate)
    {
        // 对比截至时间
        $diffDays = $this->getDiffDays(now(), $expirationDate);
        if ($diffDays < 0) {
            $shouldFinishType = DesignSubTaskStatus::FINISH_TYPE_OVERTIME;
        } else if ($diffDays == 0) {
            $shouldFinishType = DesignSubTaskStatus::FINISH_TYPE_ON_TIME;
        } else {
            $shouldFinishType = DesignSubTaskStatus::FINISH_TYPE_AHEAD;
        }
        return $shouldFinishType;
    }

    /**
     * 计算时间天数差
     * @param $startTime
     * @param $endTime
     * @return int
     */
    protected function getDiffDays($startTime, $endTime)
    {
        $deadLine = Carbon::parse($endTime);
        return Carbon::parse(Carbon::parse($startTime)->format("Y-m-d"))->diffInDays($deadLine, false);
    }
}
