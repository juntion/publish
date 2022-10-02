<?php

namespace App\ProjectManage\Models;

use App\Enums\ProjectManage\Task\MobileSubTaskStatus;
use App\Enums\ProjectManage\Task\MobileTaskColumn;
use App\Enums\ProjectManage\Task\MobileTaskStatus;
use App\Enums\ProjectManage\TaskType;
use App\Models\BaseModel;
use App\Models\User;
use App\Observers\Task\MobileTaskObserver;
use App\Traits\ActivityLogTrait;
use App\Traits\CreatedAtFilter;
use App\Traits\HasSourceProjectTrait;
use App\Traits\ModelsTrait;
use App\Traits\PolicyTrait;
use App\Traits\ProductTrait;
use App\Traits\RelatedChangesTrait;
use App\Traits\StatusLogTrait;
use App\Traits\Task\RemainingDaysTrait;
use App\Traits\Task\TaskCommonFilter;
use App\Traits\Task\TaskKeywordFilter;
use App\Traits\Task\TaskNumberTrait;
use App\Traits\Task\TaskPriorityTrait;
use App\Traits\Task\TaskProductSearch;
use App\Traits\Task\TaskStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class MobileTask extends BaseModel implements HasMedia
{
    use ModelsTrait, HasMediaTrait, StatusLogTrait, TaskNumberTrait, LogsActivity, RelatedChangesTrait, PolicyTrait, RemainingDaysTrait;
    use TaskProductSearch, TaskKeywordFilter, CreatedAtFilter, RemainingDaysTrait, TaskPriorityTrait, ActivityLogTrait, ProductTrait;
    use HasSourceProjectTrait, TaskStatusTrait, TaskCommonFilter;

    protected $table = 'pm_mobile_tasks';

    public const mediaCollectionName = 'mobileTask';
    public const TASK_PREFIX = '50';
    public const TASK_TYPE = TaskType::TASK_TYPE_MOBILE;

    protected $fillable = [
        'demand_id', 'promulgator_id', 'promulgator_name', 'principal_user_id', 'principal_user_name', 'priority',
        'expiration_date', 'content', 'status', 'start_time', 'finish_time', 'number', 'source_project_id',
        'pause_time', 'pause_date', 'title', 'share_address', 'level', 'main_principal_user_id', 'main_principal_user_name',
    ];

    protected $casts = [
        'share_address' => 'json',
    ];

    protected $showSubmitTime = false;
    protected $notShowRemainStatus = [
        MobileTaskStatus::STATUS_REVOCATION,
    ];

    protected $finishTypeNum = MobileTaskStatus::STATUS_COMPLETED;
    protected $submitTypeNum = MobileTaskStatus::STATUS_SUBMIT;

    protected $appends = ['status_desc', 'remaining_days_type', 'remaining_days', 'expect_finish_days', 'fact_finish_days', 'task_type'];

    protected static $logName = 'operation_log';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at', 'start_time', 'finish_time', 'pause_date'];
    protected static $recordEvents = ['created', 'updated'];

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

    protected static function booted()
    {
        parent::booted();

        self::observe(MobileTaskObserver::class);
    }

    public function subTasks()
    {
        return $this->hasMany(MobileSubTask::class, 'task_id');
    }

    // 主子任务
    public function mainSubTask()
    {
        return $this->subTasks()->where('is_main', 1)->with('media');
    }

    // 非主子任务
    public function otherSubTasks()
    {
        return $this->subTasks()->where('is_main', 0)->with('media');
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
        return $this->belongsToMany(Product::class, 'pm_mobile_tasks_has_products');
    }

    public function promulgatorUser()
    {
        return $this->belongsTo(User::class, 'promulgator_id')->withTrashed();
    }

    // 预计纳入版本
    public function versions()
    {
        return $this->belongsToMany(ReleaseVersion::class, 'pm_mobile_tasks_has_versions');
    }

    public function getMediaCollectionName()
    {
        return self::mediaCollectionName;
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection(self::mediaCollectionName)->useDisk('pm');
    }

    public function getStatus($status)
    {
        return MobileTaskStatus::getStatusDesc($status);
    }

    public function getProductsAttribute()
    {
        if ($this->ownProducts->isNotEmpty()) {
            return $this->ownProducts;
        }
        return optional($this->demand)->products;
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
                'name' => MobileTaskColumn::COLUMN_DESC[$key],
                'old' => $key == 'status' ? $this->getStatus($this->getOriginal($key)) : $this->getOriginal($key),
                'new' => $key == 'status' ? $this->getStatus($item) : $item,
            ];
        });
        if ($relatedChanges = $this->getRelatedChanges()) {
            $changes = array_merge($changes, $relatedChanges);
        }
        $properties['changes'] = $changes;
        return $properties;
    }

    public function shouldChangeExpirationDate()
    {
        return Str::contains(Route::currentRouteName(), 'tasks.mobile.subtasks.start')
            && !empty($this->pause_time);
    }

    public function scopeStatus(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        $const = new \ReflectionClass(MobileTaskStatus::class);
        $const_arr = $const->getConstants();
        $const_name = array_search($val, $const_arr);
        if ($const_name == "STATUS_TO_ASSIGN") {
            $part_status = 0;
        } else {
            $part_status = constant(MobileSubTaskStatus::class . "::" . $const_name);
        }
        if ($searchType == 'may') {
            $builder = $builder->orWhere('status', $val)->orWhereHas('subTasks', function ($query) use ($type, $part_status) {
                $query->where($query->qualifyColumn('status'), $part_status);
            });
        } else {
            $builder = $builder->where(function ($query) use ($type, $val, $part_status) {
                $query->where($query->qualifyColumn('status'), $val)->orWhereHas('subTasks', function ($q) use ($type, $part_status) {
                    $q->where($q->qualifyColumn('status'), $part_status);
                });
            });
        }
        return $builder;
    }
}
