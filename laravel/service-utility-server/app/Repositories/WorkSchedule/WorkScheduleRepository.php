<?php

namespace App\Repositories\WorkSchedule;

use App\Enums\WorkSchedule\WorkScheduleType;
use App\Exceptions\System\InvalidParameterException;
use App\Models\WorkSchedule\WorkSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WorkScheduleRepository
{
    /**
     * @param $year
     * @param $month
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function scheduleList($year, $month)
    {
        // 返回6周数据
        $total = 42;
        if ($month < 10 && !Str::startsWith($month, '0')) {
            $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        }
        $fields = ['id', 'date', 'type', 'morning_to_work', 'morning_off_work', 'noon_to_work', 'noon_off_work'];
        $schedules = WorkSchedule::query()->where('date', 'like', "{$year}-$month%")
            ->select($fields)->orderBy('id')->get();
        if ($schedules->isEmpty()) {
            return [];
        }
        // 计算前后日期天数
        $firstDay = $schedules->first();
        $firstDayWeek = Carbon::parse($firstDay->date)->dayOfWeek;
        if ($firstDayWeek == 0) {
            $frontDay = 6;
        } else {
            $frontDay = $firstDayWeek - 1;
        }
        $backDay = $total - $frontDay - $schedules->count();
        if ($frontDay > 0) {
            $frontDays = WorkSchedule::query()->where('date', '<', $firstDay->date)->select($fields)
                ->orderBy('id', 'desc')->limit($frontDay)->get();
            $frontDays->map(function ($day) use (&$schedules) {
                $schedules->prepend($day);
            });
        }
        $backDays = WorkSchedule::query()->where('date', '>', $schedules->last()->date)->select($fields)
            ->orderBy('id')->limit($backDay)->get();
        $schedules = $schedules->merge($backDays);
        return $schedules;
    }

    /**
     * @param WorkSchedule $schedule
     * @param Request $request
     * @throws InvalidParameterException
     */
    public function update(WorkSchedule $schedule, Request $request)
    {
        if ($request->type == WorkScheduleType::STANDARD) {
            if (!$request->has('morning_to_work') ||
                !$request->has('morning_off_work') ||
                !$request->has('noon_to_work') ||
                !$request->has('noon_off_work')) {
                throw new InvalidParameterException('班次时间不能为空');
            }
            $scheduleData = $request->only(['type', 'morning_to_work', 'morning_off_work', 'noon_to_work', 'noon_off_work',]);
            $morningHours = $this->diffInHours($request->input('morning_to_work'), $request->input('morning_off_work'));
            $noonHours = $this->diffInHours($request->input('noon_to_work'), $request->input('noon_off_work'));
            $scheduleData['working_hours'] = $morningHours + $noonHours;
        } else if ($request->type == WorkScheduleType::HALF_OF_DAY) {
            if (!$request->has('morning_to_work') ||
                !$request->has('morning_off_work')) {
                throw new InvalidParameterException('班次时间不能为空');
            }
            $scheduleData = $request->only(['type', 'morning_to_work', 'morning_off_work',]);
            $scheduleData['noon_to_work'] = null;
            $scheduleData['noon_off_work'] = null;
            $scheduleData['working_hours'] = $this->diffInHours($request->input('morning_to_work'), $request->input('morning_off_work'));
        } else {
            $scheduleData = $request->only(['type']);
            $scheduleData['morning_to_work'] = null;
            $scheduleData['morning_off_work'] = null;
            $scheduleData['noon_to_work'] = null;
            $scheduleData['noon_off_work'] = null;
            $scheduleData['working_hours'] = 0;
        }
        $scheduleData['workload'] = WorkSchedule::getScheduleWorkload($request->type);

        $user = Auth::user();
        $scheduleData['updated_user_id'] = $user->id;
        $scheduleData['updated_user_name'] = $user->name;

        $schedule->update($scheduleData);
    }

    /**
     * @param $startTime
     * @param $endTime
     * @return float
     */
    protected function diffInHours($startTime, $endTime)
    {
        $startTime = Carbon::createFromFormat('H:i', $startTime);
        $endTime = Carbon::createFromFormat('H:i', $endTime);
        return round($endTime->floatDiffInHours($startTime), 1);
    }
}
