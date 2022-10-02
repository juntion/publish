<?php

namespace App\Models\WorkSchedule;

use App\Enums\WorkSchedule\WorkScheduleType;
use App\Exceptions\System\InvalidParameterException;

trait WorkScheduleTrait
{
    /**
     * 工作量（天）
     * @param int $type
     * @return float|int
     * @throws InvalidParameterException
     */
    public static function getScheduleWorkload(int $type)
    {
        if ($type === WorkScheduleType::HALF_OF_DAY) {
            return 0.5;
        }
        if (in_array($type, [WorkScheduleType::HOLIDAYS_PUBLIC, WorkScheduleType::HOLIDAYS])) {
            return 0;
        }
        if ($type === WorkScheduleType::STANDARD) {
            return 1;
        }
        throw new InvalidParameterException('班次类型错误: ' . $type);
    }

    /**
     * 工时（小时）
     * @param int $type
     * @return float|int
     * @throws InvalidParameterException
     */
    public static function getScheduleWorkingHours(int $type)
    {
        if ($type === WorkScheduleType::HALF_OF_DAY) {
            return 2.5;
        }
        if (in_array($type, [WorkScheduleType::HOLIDAYS_PUBLIC, WorkScheduleType::HOLIDAYS])) {
            return 0;
        }
        if ($type === WorkScheduleType::STANDARD) {
            return 7.5;
        }
        throw new InvalidParameterException('班次类型错误: ' . $type);
    }

    // 上午上班时间
    public static function getMorningToWork(int $type)
    {
        if (in_array($type, [WorkScheduleType::HALF_OF_DAY, WorkScheduleType::STANDARD])) {
            return '9:30:00';
        }
        return null;
    }

    // 上午下班时间
    public static function getMorningOffWork(int $type)
    {
        if ($type === WorkScheduleType::STANDARD) {
            return '12:30:00';
        }
        if ($type === WorkScheduleType::HALF_OF_DAY) {
            return '12:00:00';
        }
        return null;
    }

    // 下午上班时间
    public static function getNoonToWork(int $type)
    {
        if ($type === WorkScheduleType::STANDARD) {
            return '14:00:00';
        }
        return null;
    }

    // 下午下班时间
    public static function getNoonOffWork(int $type)
    {
        if ($type === WorkScheduleType::STANDARD) {
            return '18:30:00';
        }
        return null;
    }
}
