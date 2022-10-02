<?php

namespace App\Traits\Task;

use App\Exceptions\System\InvalidParameterException;

trait TaskPerformanceTrait
{
    /**
     * 计算绩效等级、系数
     * 根据标准工作量进行匹配
     * @param $workload
     * @return array
     * @throws InvalidParameterException
     */
    public static function getPerformanceLevelAndFactor($workload)
    {
        if ($workload > 15) {
            return ['S', 1.4];
        }
        if ($workload > 8) {
            return ['A', 1.3];
        }
        if ($workload > 5) {
            return ['B', 1.2];
        }
        if ($workload > 2) {
            return ['C', 1.1];
        }
        if ($workload > 0) {
            return ['D', 1];
        }
        throw new InvalidParameterException('工作量天数错误: ' . $workload);
    }

    /**
     * 计算任务偏移系数
     * @param $offsetDays
     * @return float|int
     */
    public static function getOffsetFactor($offsetDays)
    {
        $offsetDays = abs($offsetDays);
        if ($offsetDays > 15) {
            return 0.8;
        }
        if ($offsetDays > 8) {
            return 0.7;
        }
        if ($offsetDays > 5) {
            return 0.6;
        }
        if ($offsetDays > 2) {
            return 0.5;
        }
        if ($offsetDays >= 1) {
            return 0.4;
        }
        return 0;
    }
}
