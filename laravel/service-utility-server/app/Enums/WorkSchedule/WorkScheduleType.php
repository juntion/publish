<?php

namespace App\Enums\WorkSchedule;

final class WorkScheduleType
{
    // 班次类型；1：标准班次；2：半天班次；3：公休；4节假日
    const STANDARD = 1;
    const HALF_OF_DAY = 2;
    const HOLIDAYS_PUBLIC = 3;
    const HOLIDAYS = 4;
}
