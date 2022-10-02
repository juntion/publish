<?php

namespace App\Traits\Task;

use Illuminate\Support\Carbon;

trait RemainingDaysTrait
{
    public function getRemainingDaysAttribute()
    {
        if (is_null($this->expiration_date)) {
            return "";
        }

        if ($this->showSubmitTime) {
            if($this->is_main == 1 && in_array($this->status, $this->MainTaskNotShowRemainStatus)){
                return "";
            } else if ($this->is_main == 0 && in_array($this->status, $this->OtherTaskNotShowRemainStatus)){
                return "";
            }
            if (!is_null($this->finish_time) && $this->status == $this->finishTypeNum) {
                $day = $this->getDiffDays($this->finish_time, $this->expiration_date);
            } else if (!is_null($this->submit_time) && $this->status == $this->submitTypeNum){
                $day = $this->getDiffDays($this->submit_time, $this->expiration_date);
            } else {
                $day = $this->getDiffDays(Carbon::now(), $this->expiration_date);
            }
        } else {
            if (in_array($this->status, $this->notShowRemainStatus)){
                return "";
            }
            if (is_null($this->finish_time)) {
                $day = $this->getDiffDays(Carbon::now(), $this->expiration_date);
            } else {
                $day = $this->getDiffDays($this->finish_time, $this->expiration_date);
            }
        }
        return $day;
    }


    protected function getDiffDays($startTime, $endTime)
    {
        $dead_line = Carbon::parse($endTime);
        return Carbon::parse(Carbon::parse($startTime)->format("Y-m-d"))->diffInDays($dead_line, false);
    }

    public function getRemainingDaysTypeAttribute()
    {
        $type = 0; // 进行中
        if ($this->showSubmitTime) {
            if (!is_null($this->finish_time) && $this->status == $this->finishTypeNum) {
                $type = 2; // 已完成
            } else if (!is_null($this->submit_time) && $this->status == $this->submitTypeNum) {
                $type = 1; // 已提交
            }
        } else {
            if (!is_null($this->finish_time)) {
                $type = 2; // 已完成
            }
        }
        return $type;
    }

    // 预计完成时间
    public function getExpectFinishDaysAttribute()
    {
        if (is_null($this->expiration_date)) {
            return "";
        }
        return $this->getDiffDays($this->created_at->toDateString(), $this->expiration_date);
    }

    // 实际处理时间
    public function getFactFinishDaysAttribute()
    {
        if (is_null($this->finish_time)) {
            return '';
        }
        return $this->getDiffDays($this->start_time, $this->finish_time);
    }
}
