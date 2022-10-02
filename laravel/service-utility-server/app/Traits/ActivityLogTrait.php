<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

trait ActivityLogTrait
{
    /**
     * 记录操作日志
     * @param $logDesc
     * @param null $user
     * @param array $properties
     */
    public function createActivityLog($logDesc, $user = null, array $properties = [])
    {
        $user = $user ?? Auth::user();
        activity()
            ->performedOn($this)
            ->causedBy($user)
            ->withProperties($properties)
            ->log($logDesc);
    }

    public function activityLogs()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    /**
     * @return \Closure
     */
    public function getOperationLog()
    {
        return function ($activity) {
            return [
                'created_at' => $activity->created_at->toDateTimeString(),
                'user_name' => getUserNameById($activity->causer_id),
                'description' => $activity->description,
                'changes' => $activity->properties->get('changes'),
            ];
        };
    }
}
