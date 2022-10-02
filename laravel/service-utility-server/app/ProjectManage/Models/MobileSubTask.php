<?php

namespace App\ProjectManage\Models;

use App\Enums\ProjectManage\Task\MobileSubTaskStatus;
use App\Enums\ProjectManage\TaskType;
use App\Models\BaseModel;
use App\Observers\Task\MobileSubTaskObserver;
use App\Traits\ModelsTrait;
use App\Traits\PolicyTrait;
use App\Traits\StatusLogTrait;
use App\Traits\Task\RemainingDaysTrait;
use App\Traits\Task\TaskNumberTrait;
use App\Traits\Task\TaskPerformanceTrait;
use App\Traits\Task\TaskPriorityTrait;
use App\Traits\Task\TaskStatusTrait;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class MobileSubTask extends BaseModel implements HasMedia
{
    use HasMediaTrait, ModelsTrait, StatusLogTrait, TaskNumberTrait, PolicyTrait, TaskPriorityTrait, RemainingDaysTrait;
    use TaskStatusTrait, TaskPerformanceTrait;

    protected $table = 'pm_mobile_sub_tasks';
    protected $appends = ['remaining_days_type', 'remaining_days', 'status_desc', 'expect_finish_days', 'fact_finish_days', 'task_type'];

    public const mediaCollectionName = 'mobileSubTask';
    public const TASK_TYPE = TaskType::TASK_TYPE_MOBILE;

    protected $fillable = [
        'task_id', 'priority', 'expiration_date', 'description', 'handler_id', 'handler_name', 'share_address',
        'status', 'is_main', 'start_time', 'finish_time', 'submit_time', 'pause_time', 'pause_date', 'finish_type', 'difference_reason',
        'release_type', 'branch_name', 'has_sql', 'release_version_id', 'stress_test', 'release_comment', 'product_confirmed',
        'standard_workload', 'standard_factor', 'performance_level', 'offset_days', 'offset_factor', 'adjust_reason', 'release_status',
    ];

    protected $casts = [
        'share_address' => 'json',
    ];

    protected $showSubmitTime = true;

    protected $MainTaskNotShowRemainStatus = [
        MobileSubTaskStatus::STATUS_REVOCATION,
        MobileSubTaskStatus::STATUS_PAUSED,
    ];
    protected $OtherTaskNotShowRemainStatus = [
        MobileSubTaskStatus::STATUS_REVOCATION,
        MobileSubTaskStatus::STATUS_PAUSED,
    ];

    protected $finishTypeNum = MobileSubTaskStatus::STATUS_COMPLETED;
    protected $submitTypeNum = MobileSubTaskStatus::STATUS_SUBMIT;

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

    protected static function booted()
    {
        parent::booted();

        self::observe(MobileSubTaskObserver::class);
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
        return MobileSubTaskStatus::getStatusDesc($status);
    }

    public function task()
    {
        return $this->belongsTo(MobileTask::class);
    }

    public function demand()
    {
        $task = $this->task()->first();
        return $task->demand()->first();
    }

    public function hasDemand()
    {
        return $this->hasOneThrough(Demand::class, MobileTask::class, 'id', 'id', 'task_id', 'demand_id');
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
        return Str::contains(Route::currentRouteName(), 'tasks.mobile.subtasks.start')
            && !empty($this->pause_time);
    }
}
