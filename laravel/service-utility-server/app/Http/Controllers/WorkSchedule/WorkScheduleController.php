<?php

namespace App\Http\Controllers\WorkSchedule;

use App\Http\Controllers\Controller;
use App\Models\WorkSchedule\WorkSchedule;
use App\Repositories\WorkSchedule\WorkScheduleRepository;
use Illuminate\Http\Request;

class WorkScheduleController extends Controller
{
    /**
     * @var WorkScheduleRepository
     */
    private $workSchedule;

    public function __construct(WorkScheduleRepository $workSchedule)
    {
        parent::__construct();

        $this->workSchedule = $workSchedule;
    }

    /**
     * @param $year
     * @param $month
     * @return \Illuminate\Http\JsonResponse
     */
    public function scheduleList($year, $month)
    {
        $schedules = $this->workSchedule->scheduleList($year, $month);
        return $this->successWithData(compact('schedules'));
    }

    /**
     * @param Request $request
     * @param WorkSchedule $schedule
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, WorkSchedule $schedule)
    {
        $request->validate([
            'type' => 'required|in:1,2,3,4',
            'morning_to_work' => 'date_format:H:i',
            'morning_off_work' => 'date_format:H:i',
            'noon_to_work' => 'date_format:H:i',
            'noon_off_work' => 'date_format:H:i',
        ], [], [
            'type' => '班次类型',
            'morning_to_work' => '上午上班时间',
            'morning_off_work' => '上午下班时间',
            'noon_to_work' => '中午上班时间',
            'noon_off_work' => '中午下班时间',
        ]);

        $this->workSchedule->update($schedule, $request);
        return $this->success();
    }
}
