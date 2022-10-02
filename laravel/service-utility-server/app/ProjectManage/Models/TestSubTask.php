<?php

namespace App\ProjectManage\Models;

use App\Enums\ProjectManage\TaskType;
use App\Enums\ProjectManage\TestSubTaskStatus;
use App\Traits\DateFormatTrait;
use App\Traits\ModelsTrait;
use App\Traits\PolicyTrait;
use App\Traits\StatusLogTrait;
use App\Traits\Task\RemainingDaysTrait;
use App\Traits\Task\TaskNumberTrait;
use App\Traits\Task\TaskPriorityTrait;
use App\Traits\Task\TaskStatusTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class TestSubTask extends Model implements HasMedia
{
    use ModelsTrait, HasMediaTrait, StatusLogTrait, TaskNumberTrait, PolicyTrait, TaskPriorityTrait, RemainingDaysTrait;
    use TaskStatusTrait, DateFormatTrait;

    protected $table = 'pm_test_sub_tasks';

    protected $appends = ['remaining_days_type', 'remaining_days', 'status_desc', 'expect_finish_days', 'fact_finish_days', 'task_type'];

    protected $fillable = [
        'task_id', 'priority', 'expiration_date', 'description', 'handler_id', 'handler_name', 'share_address',
        'status', 'result', 'feedback', 'is_main', 'start_time', 'finish_time', 'submit_time', 'pause_time', 'pause_date',
        'finish_type', 'difference_reason',
    ];

    protected $casts = [
        'share_address' => 'json'
    ];

    const mediaCollectionName = 'testSubTask';
    const TASK_TYPE = TaskType::TASK_TYPE_TEST;

    protected $showSubmitTime = true;

    protected $MainTaskNotShowRemainStatus = [
        TestSubTaskStatus::STATUS_REVOCATION,
        TestSubTaskStatus::STATUS_PAUSED
    ];
    protected $OtherTaskNotShowRemainStatus = [
        TestSubTaskStatus::STATUS_REVOCATION,
        TestSubTaskStatus::STATUS_PAUSED
    ];
    protected $finishTypeNum = TestSubTaskStatus::STATUS_COMPLETED;
    protected $submitTypeNum = TestSubTaskStatus::STATUS_SUBMIT;

    public function getMediaCollectionName()
    {
        return self::mediaCollectionName;
    }

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

    public function getStatus($val)
    {
        return TestSubTaskStatus::getStatusDesc($val);
    }

    public function task()
    {
        return $this->belongsTo(TestTask::class);
    }

    public function demand()
    {
        $task = $this->task()->first();
        return $task->demand()->first();
    }

    public function hasDemand()
    {
        return $this->hasOneThrough(Demand::class, TestTask::class, 'id', 'id', 'task_id', 'demand_id');
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
        return Str::contains(Route::currentRouteName(), 'tasks.test.subtasks.start')
            && !empty($this->pause_time);
    }
}
