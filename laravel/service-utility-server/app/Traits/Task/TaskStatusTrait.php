<?php

namespace App\Traits\Task;

use App\ProjectManage\Models\DesignPart;
use Illuminate\Support\Carbon;

trait TaskStatusTrait
{
    public function setStatusAttribute($newStatus)
    {
        if ($this->shouldChangeExpirationDate()) {
            $pauseDate = date('Y-m-d', strtotime($this->pause_time));
            $addDays = Carbon::parse($pauseDate)->diffInDays(Carbon::now()->toDateString());
            if ($addDays > 0 && $this->expiration_date) {
                if (!($this instanceof DesignPart)) {
                    $this->attributes['expiration_date'] = Carbon::parse($this->expiration_date)->addDays($addDays);
                }
                $this->attributes['pause_date'] = $this->pause_date + $addDays;
            }
        }
        $this->attributes['status'] = $newStatus;
    }

    /**
     * 操作为开始 且 暂停时间存在（任务暂停过），修改预计交付时间（暂停了多少天就加多少天）
     * @return bool
     */
    public function shouldChangeExpirationDate()
    {
        return false;
    }
}
