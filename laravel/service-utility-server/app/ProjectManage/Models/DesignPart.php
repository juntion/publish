<?php

namespace App\ProjectManage\Models;

use App\Enums\ProjectManage\DesignPartStatus;
use App\Traits\DateFormatTrait;
use App\Traits\PolicyTrait;
use App\Traits\StatusLogTrait;
use App\Traits\Task\TaskStatusTrait;
use App\Traits\Task\TaskNumberTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class DesignPart extends Model
{
    use StatusLogTrait, TaskNumberTrait, PolicyTrait, TaskStatusTrait, DateFormatTrait;

    protected $table = 'pm_design_parts';

    protected $fillable = [
        'task_id', 'type', 'principal_user_id', 'principal_user_name', 'status', 'stage', 'start_time', 'finish_time',
        'pause_time', 'pause_date',
    ];

    protected $appends = ['status_desc',];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->number) {
                $model->number = $model->findSubTaskNumber();
                if (!$model->number) {
                    return false;
                }
            }
        });
    }

    // 所属任务
    public function task()
    {
        return $this->belongsTo(DesignTask::class);
    }

    public function demand()
    {
        $task = $this->task()->first();
        return $task->demand()->first();
    }

    public function subTasks()
    {
        return $this->hasMany(DesignSubTask::class, 'part_id');
    }

    public function mainSubTask()
    {
        return $this->subTasks()->where('is_main', 1)->with('media');
    }

    public function otherSubTasks()
    {
        return $this->subTasks()->where('is_main', 0)->with('media');
    }

    public function getStatus($status)
    {
        return DesignPartStatus::getStatusDesc($status);
    }

    public function shouldChangeExpirationDate()
    {
        return Str::contains(Route::currentRouteName(), 'tasks.design.parts.subtasks.start')
            && !empty($this->pause_time);
    }
}
