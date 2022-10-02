<?php

namespace App\ProjectManage\Models;

use App\Enums\ProjectManage\DesignSubTaskStatus;
use App\Enums\ProjectManage\TaskType;
use App\Traits\DateFormatTrait;
use App\Traits\ModelsTrait;
use App\Traits\PolicyTrait;
use App\Traits\StatusLogTrait;
use App\Traits\Task\RemainingDaysTrait;
use App\Traits\Task\TaskPriorityTrait;
use App\Traits\Task\TaskStatusTrait;
use App\Traits\Task\TaskNumberTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class DesignSubTask extends Model implements HasMedia
{
    use ModelsTrait, HasMediaTrait, StatusLogTrait, TaskNumberTrait, PolicyTrait, TaskPriorityTrait, RemainingDaysTrait;
    use TaskStatusTrait, DateFormatTrait;

    const mediaCollection = 'designSubTask';
    const TASK_TYPE = TaskType::TASK_TYPE_DESIGN;

    protected $table = 'pm_design_sub_tasks';

    protected $fillable = [
        'task_id', 'part_id', 'priority', 'expiration_date', 'description', 'handler_id', 'handler_name', 'share_address',
        'status', 'is_main', 'start_time', 'finish_time', 'submit_time', 'pause_time', 'pause_date', 'finish_type', 'difference_reason',
        'release_type', 'branch_name', 'has_sql', 'release_version_id', 'stress_test', 'release_comment', 'product_confirmed', 'release_status',
    ];

    protected $casts = [
        'share_address' => 'json'
    ];

    protected $appends = ['remaining_days_type', 'remaining_days', 'status_desc', 'expect_finish_days', 'fact_finish_days', 'task_type'];

    protected $showSubmitTime = true;
    protected $MainTaskNotShowRemainStatus = [
        DesignSubTaskStatus::STATUS_REVOCATION,
        DesignSubTaskStatus::STATUS_PAUSED
    ];
    protected $OtherTaskNotShowRemainStatus = [
        DesignSubTaskStatus::STATUS_REVOCATION,
        DesignSubTaskStatus::STATUS_PAUSED
    ];

    protected $finishTypeNum = DesignSubTaskStatus::STATUS_COMPLETED;
    protected $submitTypeNum = DesignSubTaskStatus::STATUS_SUBMIT;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->number) {
                $model->number = $model->findSubTaskNumber(true);
                if (!$model->number) {
                    return false;
                }
            }
        });
    }

    public function getProjectMedia()
    {
        return $this->getMediaCollectionName();
    }

    public function part()
    {
        return $this->belongsTo(DesignPart::class);
    }

    public function task()
    {
        return $this->belongsTo(DesignTask::class);
    }

    public function version()
    {
        return $this->belongsTo(ReleaseVersion::class, 'release_version_id');
    }

    public function demand()
    {
        $task = $this->task()->first();
        return $task->demand()->first();
    }

    public function hasDemand()
    {
        return $this->hasOneThrough(Demand::class, DesignTask::class, 'id', 'id', 'task_id', 'demand_id');
    }

    public function getStatus($status)
    {
        return DesignSubTaskStatus::getStatusDesc($status);
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection(self::mediaCollection)->useDisk('pm');
    }

    public function getMediaCollectionName()
    {
        return self::mediaCollection;
    }

    // 角色环节负责人和处理人
    public function principalAndHandler()
    {
        return collect($this->partPrincipal())
            ->merge($this->handler_id)
            ->unique()->filter()->toArray();
    }

    // 角色环节负责人
    public function partPrincipal()
    {
        return $this->part->principal_user_id;
    }

    // 角色环节负责人和主任务负责人
    public function principals()
    {
        return collect($this->task->principal_user_id)
            ->merge($this->partPrincipal())
            ->unique()->filter()->toArray();
    }

    public function shouldChangeExpirationDate()
    {
        return Str::contains(Route::currentRouteName(), 'tasks.design.parts.subtasks.start')
            && !empty($this->pause_time);
    }

    public function getPartTypeAttribute()
    {
        return $this->part->type;
    }
}
