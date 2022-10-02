<?php

namespace App\ProjectManage\Models;

use App\Enums\ProjectManage\DesignPartStatus;
use App\Enums\ProjectManage\DesignPartType;
use App\Enums\ProjectManage\DesignTaskColumn;
use App\Enums\ProjectManage\DesignTaskStatus;
use App\Enums\ProjectManage\TaskType;
use App\Models\User;
use App\Traits\ActivityLogTrait;
use App\Traits\CreatedAtFilter;
use App\Traits\DateFormatTrait;
use App\Traits\HasSourceProjectTrait;
use App\Traits\ModelsTrait;
use App\Traits\PolicyTrait;
use App\Traits\ProductTrait;
use App\Traits\RelatedChangesTrait;
use App\Traits\StatusLogTrait;
use App\Traits\Task\RemainingDaysTrait;
use App\Traits\Task\TaskPriorityTrait;
use App\Traits\Task\TaskStatusTrait;
use App\Traits\Task\TaskKeywordFilter;
use App\Traits\Task\TaskNumberTrait;
use App\Traits\Task\TaskProductSearch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class DesignTask extends Model implements HasMedia
{
    use HasMediaTrait, ModelsTrait, StatusLogTrait, TaskNumberTrait, LogsActivity, RelatedChangesTrait;
    use TaskProductSearch, CreatedAtFilter, TaskKeywordFilter, PolicyTrait, RemainingDaysTrait, TaskPriorityTrait, ActivityLogTrait;
    use HasSourceProjectTrait, ProductTrait, TaskStatusTrait, DateFormatTrait;

    const mediaCollection = 'designTask';
    const createMediaCollection = 'createDesignTask';
    const reviewMediaCollection = 'reviewDesignTask';

    const TASK_PREFIX = '10';
    const TASK_TYPE = TaskType::TASK_TYPE_DESIGN;

    protected $table = 'pm_design_tasks';
    protected $showSubmitTime = false;
    protected $notShowRemainStatus = [
        DesignTaskStatus::STATUS_COMPLETED,
        DesignTaskStatus::STATUS_REVOCATION
    ];

    protected $finishTypeNum = DesignTaskStatus::STATUS_COMPLETED;
    protected $submitTypeNum = DesignTaskStatus::STATUS_SUBMIT;

    protected $fillable = [
        'demand_id', 'promulgator_id', 'promulgator_name', 'principal_user_id', 'principal_user_name', 'priority',
        'expiration_date', 'content', 'status', 'review', 'review_result', 'review_comment', 'review_time', 'reviewer_id',
        'reviewer_name', 'start_time', 'finish_time', 'design_type', 'number', 'verify_time', 'source_project_id',
        'pause_time', 'pause_date', 'title', 'share_address', 'main_principal_user_id', 'main_principal_user_name',
    ];

    protected $appends = ['status_desc', 'remaining_days_type', 'remaining_days', 'expect_finish_days', 'fact_finish_days', 'task_type'];

    protected static $logName = 'operation_log';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at', 'start_time', 'finish_time', 'pause_date'];
    protected static $recordEvents = ['created', 'updated'];

    protected $casts = [
        'share_address' => 'json',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->number) {
                $model->number = static::findAvailableTaskNumber();
                if (!$model->number) {
                    return false;
                }
            }
        });
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection(self::mediaCollection)->useDisk('pm');
        $this->addMediaCollection(self::createMediaCollection)->useDisk('pm');
        $this->addMediaCollection(self::reviewMediaCollection)->useDisk('pm');
    }

    public function getMediaCollectionName()
    {
        $routeName = Route::currentRouteName();
        if (Str::contains($routeName, ['tasks.design.store', 'tasks.design.update'])) {
            return self::createMediaCollection;
        }
        if (Str::contains($routeName, 'tasks.design.review')) {
            return self::reviewMediaCollection;
        }
        return self::mediaCollection;
    }

    // 设计任务拥有的环节
    public function parts()
    {
        return $this->hasMany(DesignPart::class, 'task_id');
    }

    public function subTasks()
    {
        return $this->hasMany(DesignSubTask::class, 'task_id');
    }

    public function demand()
    {
        return $this->belongsTo(Demand::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'source_project_id');
    }

    public function ownProducts()
    {
        return $this->belongsToMany(Product::class, 'pm_design_tasks_has_products');
    }

    public function promulgatorUser()
    {
        return $this->belongsTo(User::class, 'promulgator_id')->withTrashed();
    }

    // 预计纳入版本
    public function versions()
    {
        return $this->belongsToMany(ReleaseVersion::class, 'pm_design_tasks_has_versions');
    }

    public function getProductsAttribute()
    {
        if ($this->ownProducts->isNotEmpty()) {
            return $this->ownProducts;
        }
        return optional($this->demand)->products;
    }

    public function getStatus($status)
    {
        return DesignTaskStatus::getStatusDesc($status);
    }

    // 主负责人|视觉负责人/视觉跟进人/交互跟进人/交互负责人
    public function canReviewUsers()
    {
        $handlerIds = [];
        $parts = $this->parts->whereIn('type', [DesignPartType::VISUAL, DesignPartType::INTERACTIVE]);
        $parts->each(function ($part) use (&$handlerIds) {
            if ($part->main_subtask && !is_array($part->main_subtask)) {
                $handlerIds = $part->main_subtask->pluck('handler_id')
                    ->merge($part->other_subtasks->pluck('handler_id'))
                    ->merge($handlerIds);
            } else {
                $handlerIds = $part->subTasks()->get()->pluck('handler_id')->merge($handlerIds);
            }
        });
        return $parts->pluck('principal_user_id')
            ->merge($handlerIds)
            ->merge($this->principal_user_id)
            ->unique()->toArray();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $userName = Auth::user()->name;
        switch ($eventName) {
            case 'created':
                return "由 {$userName} 创建";
            case 'updated':
                return "由 {$userName} 编辑";
        }
    }

    public function attributeValuesToBeLogged(string $processingEvent): array
    {
        if ($processingEvent == 'created') {
            return [];
        }

        if (!count($this->attributesToBeLogged())) {
            return [];
        }

        $properties['attributes'] = static::logChanges(
            $this->exists
                ? $this->fresh() ?? $this
                : $this
        );

        if (static::eventsToBeRecorded()->contains('updated') && $processingEvent == 'updated') {
            $nullProperties = array_fill_keys(array_keys($properties['attributes']), null);

            $properties['old'] = array_merge($nullProperties, $this->oldAttributes);

            $this->oldAttributes = [];
        }

        if ($this->shouldLogOnlyDirty() && isset($properties['old'])) {
            $properties['attributes'] = array_udiff_assoc(
                $properties['attributes'],
                $properties['old'],
                function ($new, $old) {
                    if ($old === null || $new === null) {
                        return $new === $old ? 0 : 1;
                    }

                    return $new <=> $old;
                }
            );
            $properties['old'] = collect($properties['old'])
                ->only(array_keys($properties['attributes']))
                ->all();
        }

        $changes = [];
        collect($this->getDirty())->except(self::$logAttributesToIgnore)->map(function ($item, $key) use (&$changes) {
            $changes[] = [
                'name' => DesignTaskColumn::COLUMN_DESC[$key],
                'old'  => $key == 'status' ? $this->getStatus($this->getOriginal($key)) : $this->getOriginal($key),
                'new'  => $key == 'status' ? $this->getStatus($item) : $item,
            ];
        });
        if ($relatedChanges = $this->getRelatedChanges()) {
            $changes = array_merge($changes, $relatedChanges);
        }
        $properties['changes'] = $changes;
        return $properties;
    }

    public function scopePrincipalUser(Builder $builder, $data)
    {
        $builder->where('principal_user_id', $data)->orWhereHas('parts', function ($query) use ($data) {
            $query->where($query->qualifyColumn('principal_user_id'), $data);
        });
        return $builder;
    }

    public function shouldChangeExpirationDate()
    {
        return Str::contains(Route::currentRouteName(), 'tasks.design.parts.subtasks.start')
            && !empty($this->pause_time);
    }

    public function scopeStatus(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        $const = new \ReflectionClass(DesignTaskStatus::class);
        $const_arr = $const->getConstants();
        $const_name = array_search($val, $const_arr);
        if ($const_name == "STATUS_TO_AUDIT") {
            $part_status = 0;
        } else {
            $part_status = constant(DesignPartStatus::class."::".$const_name);
        }
        if ($searchType == 'may'){
            $builder = $builder->orWhere('status', $val)->orWhereHas('parts', function($query)use($type, $part_status){
                $query->where($query->qualifyColumn('status'), $part_status);
            });
        } else {
            $builder = $builder->where(function ($query)use($type, $val, $part_status){
               $query->where($query->qualifyColumn('status'), $val)->orWhereHas('parts', function($q)use($type, $part_status){
                   $q->where($q->qualifyColumn('status'), $part_status);
               });
            });
        }
        return $builder;
    }

    /**
     * 完成时间搜索
     * @param Builder $builder
     * @param mixed ...$data
     * @return Builder
     */
    public function scopeFinishTime(Builder $builder, ...$data)
    {
        $startTime = $data[1][0] . " 00:00:00";
        $endTime = $data[1][1] . " 23:59:59";
        $searchType = $data[2];
        if ($searchType == 'may') {
            $builder = $this->searchFinishTime($builder, request()->input('may'), $startTime, $endTime);
        } else {
            $builder = $this->searchFinishTime($builder, request()->input('must'), $startTime, $endTime);
        }
        return $builder;
    }

    /**
     * @param Builder $builder
     * @param array $searchData
     * @param string $startTime
     * @param string $endTime
     * @return Builder
     */
    protected function searchFinishTime(Builder $builder, array $searchData, string $startTime, string $endTime): Builder
    {
        if (isset($searchData['parts.subTasks.handler_id,is'])) {
            $builder = $builder->whereHas('subTasks', function ($query) use ($startTime, $endTime, $searchData) {
                $query->whereBetween($query->qualifyColumn('finish_time'), [$startTime, $endTime])
                    ->where($query->qualifyColumn('handler_id'), $searchData['parts.subTasks.handler_id,is']);
            });
        } else if (isset($searchData['parts.principal_user_id,is'])) {
            $builder = $builder->whereHas('parts', function ($query) use ($startTime, $endTime, $searchData) {
                $query->whereBetween($query->qualifyColumn('finish_time'), [$startTime, $endTime])
                    ->where($query->qualifyColumn('principal_user_id'), $searchData['parts.principal_user_id,is']);
            });
        } else {
            $builder = $builder->whereBetween($builder->qualifyColumn('finish_time'), [$startTime, $endTime]);
        }
        return $builder;
    }

    public function scopeSubTaskStatus(Builder $builder, $data)
    {
        $searchData = request()->input('search');
        if (isset($searchData['parts.subTasks.handler_id'])) {
            $builder = $builder->whereHas('subTasks', function ($query) use ($searchData, $data) {
                $query->where($query->qualifyColumn('status'), $data)
                    ->where($query->qualifyColumn('handler_id'), $searchData['parts.subTasks.handler_id']);
            });
        } else {
            $builder = $builder->whereHas('subTasks', function ($query) use ($searchData, $data) {
                $query->where($query->qualifyColumn('status'), $data);
            });
        }
        return $builder;
    }
}
