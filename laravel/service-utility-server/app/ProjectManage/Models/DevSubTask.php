<?php

namespace App\ProjectManage\Models;

use App\Enums\ProjectManage\DevSubTaskStatus;
use App\Enums\ProjectManage\TaskType;
use App\Traits\DateFormatTrait;
use App\Traits\ModelsTrait;
use App\Traits\PolicyTrait;
use App\Traits\StatusLogTrait;
use App\Traits\Task\RemainingDaysTrait;
use App\Traits\Task\TaskNumberTrait;
use App\Traits\Task\TaskPerformanceTrait;
use App\Traits\Task\TaskPriorityTrait;
use App\Traits\Task\TaskStatusTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class DevSubTask extends Model implements HasMedia
{
    use HasMediaTrait, ModelsTrait, StatusLogTrait, TaskNumberTrait, PolicyTrait, TaskPriorityTrait, RemainingDaysTrait;
    use TaskStatusTrait, DateFormatTrait, TaskPerformanceTrait;

    protected $table = 'pm_dev_sub_tasks';
    protected $appends = ['remaining_days_type', 'remaining_days', 'status_desc', 'expect_finish_days', 'fact_finish_days', 'task_type'];

    const mediaCollectionName = 'devSubTask';
    const TASK_TYPE = TaskType::TASK_TYPE_DEV;

    protected $fillable = [
        'task_id', 'priority', 'expiration_date', 'description', 'handler_id', 'handler_name', 'share_address',
        'status', 'is_main', 'start_time', 'finish_time', 'submit_time', 'pause_time', 'pause_date', 'finish_type', 'difference_reason',
        'release_type', 'branch_name', 'has_sql', 'release_version_id', 'stress_test', 'release_comment', 'product_confirmed', 'release_status',
        'standard_workload', 'standard_factor', 'performance_level', 'offset_days', 'offset_factor', 'adjust_reason',
    ];
    protected $showSubmitTime = true;

    protected $MainTaskNotShowRemainStatus = [
        DevSubTaskStatus::STATUS_REVOCATION,
        DevSubTaskStatus::STATUS_PAUSED,
    ];
    protected $OtherTaskNotShowRemainStatus = [
        DevSubTaskStatus::STATUS_REVOCATION,
        DevSubTaskStatus::STATUS_PAUSED,
    ];

    protected $finishTypeNum = DevSubTaskStatus::STATUS_COMPLETED;
    protected $submitTypeNum = DevSubTaskStatus::STATUS_SUBMIT;

    protected $casts = [
        'share_address' => 'json',
    ];

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

    public function registerMediaCollections()
    {
        $this->addMediaCollection(self::mediaCollectionName)->useDisk('pm');
    }

    public function getProjectMedia()
    {
        return $this->getMediaCollectionName();
    }

    public function getMediaCollectionName()
    {
        return self::mediaCollectionName;
    }

    public function getStatus($status)
    {
        return DevSubTaskStatus::getStatusDesc($status);
    }

    public function task()
    {
        return $this->belongsTo(DevTask::class);
    }

    public function demand()
    {
        $task = $this->task()->first();
        return $task->demand()->first();
    }

    public function hasDemand()
    {
        return $this->hasOneThrough(Demand::class, DevTask::class, 'id', 'id', 'task_id', 'demand_id');
    }

    public function version()
    {
        return $this->belongsTo(ReleaseVersion::class, 'release_version_id');
    }

    public function principalAndHandler()
    {
        $taskPrincipal = $this->task->principal_user_id;
        return collect($taskPrincipal)
            ->merge($this->handler_id)
            ->unique()->filter()->toArray();
    }

    public function shouldChangeExpirationDate()
    {
        return Str::contains(Route::currentRouteName(), 'tasks.dev.subtasks.start')
            && !empty($this->pause_time);
    }

}
