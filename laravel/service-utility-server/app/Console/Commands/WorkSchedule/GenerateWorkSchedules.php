<?php

namespace App\Console\Commands\WorkSchedule;

use App\Enums\WorkSchedule\WorkScheduleType;
use App\Exceptions\System\InvalidParameterException;
use App\Models\WorkSchedule\WorkSchedule;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class GenerateWorkSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:generate-work-schedules {year? : 年份}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成班次表(按年)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $workSchedulesData = $this->workSchedulesData();
        $firstDate = Arr::first($workSchedulesData);
        if (WorkSchedule::query()->where('date', $firstDate['date'])->exists()) {
            throw new \Exception('数据已存在，请勿重复执行');
        }

        DB::transaction(function () use ($workSchedulesData) {
            WorkSchedule::query()->insert($workSchedulesData);
        });
        $this->info('操作成功！');
    }

    private function workSchedulesData(): array
    {
        $result = [];
        if ($year = $this->argument('year')) {
            $benign = strtotime(date("{$year}-01-01"));
        } else {
            $benign = strtotime(date('Y-01-01'));
        }
        $end = Carbon::createFromTimestamp($benign)->addYear()->getTimestamp();
        for ($date = $benign; $date < $end; $date += 86400) {
            $dateObj = Carbon::createFromTimestamp($date);
            $type = $this->getScheduleType($dateObj);
            $result[] = [
                'date' => $dateObj->toDateString(),
                'type' => $type,
                'workload' => WorkSchedule::getScheduleWorkload($type),
                'working_hours' => WorkSchedule::getScheduleWorkingHours($type),
                'morning_to_work' => WorkSchedule::getMorningToWork($type),
                'morning_off_work' => WorkSchedule::getMorningOffWork($type),
                'noon_to_work' => WorkSchedule::getNoonToWork($type),
                'noon_off_work' => WorkSchedule::getNoonOffWork($type),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return $result;
    }

    /**
     * 班次类型
     * @param Carbon $date
     * @return int
     */
    private function getScheduleType(Carbon $date)
    {
        $week = $date->dayOfWeek;
        // 周六 半天班次，工作量 0.5
        if ($week === 6) {
            return WorkScheduleType::HALF_OF_DAY;
        }

        // 周日 公休或节假日，工作量 0
        if ($week === 0) {
            return WorkScheduleType::HOLIDAYS_PUBLIC;
        }

        // 工作日 标准班次 工作量 1
        return WorkScheduleType::STANDARD;
    }
}
