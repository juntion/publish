<?php

namespace App\ProjectManage\Models;

use App\Models\User;
use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Activity
{
    use DateFormatTrait;

    protected $table = 'activity_log';
    protected $appends = ['user_name'];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function getUserNameAttribute()
    {
        $user = User::query()->withTrashed()->find($this->causer_id);
        if ($user->deleted_at) {
            return "离职人员(". $user->name .")";
        }
        return $user->name;
    }
}
