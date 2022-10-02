<?php

namespace App\ProjectManage\Models;

use App\Enums\ProjectManage\BugColumn;
use App\Enums\ProjectManage\BugDataRestore;
use App\Enums\ProjectManage\BugExamineStatus;
use App\Enums\ProjectManage\BugStatus;
use App\Enums\ProjectManage\OperationPlatform;
use App\Exceptions\System\InvalidParameterException;
use App\Models\Department;
use App\Models\User;
use App\Traits\ActivityLogTrait;
use App\Traits\CreatedAtFilter;
use App\Traits\DateFormatTrait;
use App\Traits\ExamineLogTrait;
use App\Traits\ModelsTrait;
use App\Traits\PolicyTrait;
use App\Traits\ProductTrait;
use App\Traits\RelatedChangesTrait;
use App\Traits\SearchProduct;
use App\Traits\StatusLogTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Bug extends Model implements HasMedia
{
    use HasMediaTrait, ModelsTrait, StatusLogTrait, LogsActivity, ActivityLogTrait, RelatedChangesTrait, PolicyTrait;
    use ExamineLogTrait, ProductTrait, SearchProduct, CreatedAtFilter, DateFormatTrait;

    protected $table = 'pm_bugs';

    protected $fillable = [
        'number', 'dept_id', 'dept_name', 'promulgator_id', 'promulgator_name', 'status', 'examine_status', 'is_urgent', 'description',
        'operation_account', 'browser', 'operation_platform', 'links', 'version', 'start_time', 'end_time', 'source_project_id', 'source_project_name',
        'source_demand_id', 'source_demand_name', 'product_principal_id', 'product_principal_name', 'program_principal_id', 'program_principal_name',
        'test_principal_id', 'test_principal_name', 'expiration_date', 'comment', 'resolve_status', 'solution', 'reason_id', 'reason_analyse', 'data_restore',
        'data_restore_comment', 'inquiry_progress', 'start_handle_time', 'submit_time', 'finish_time', 'erp_bug_id', 'erp_bug_number',
    ];

    protected $casts = [
        'operation_account' => 'json',
        'browser'           => 'json',
        'links'             => 'json',
    ];

    protected $appends = ['status_desc', 'examine_status_desc', 'remaining_days_type', 'remaining_days'];

    // 附件保存的 collection_name
    const media = 'bugs';

    protected static $logName = 'operation_log';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at', 'comment', 'resolve_status', 'reason_id', 'start_handle_time', 'submit_time', 'finish_time', 'source_project_id', 'source_demand_id'];
    protected static $recordEvents = ['created', 'updated'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->number) {
                $model->number = static::findAvailableNo($model);
                if (!$model->number) {
                    return false;
                }
            }
        });
    }

    // 生成bug编号
    public static function findAvailableNo($model)
    {
        $prefix = self::getNumberPrefix($model);
        for ($i = 0; $i < 10; $i++) {
            $lastBug = static::query()
                ->where('number', 'like', "{$prefix}%")
                ->where('created_at', '>=', date('Y-m-01 00:00:00'))
                ->orderBy('id', 'desc')->first();
            if ($lastBug) {
                $lastNo = substr($lastBug->number, -3);
                $no = $prefix . str_pad((intval($lastNo) + 1), 3, '0', STR_PAD_LEFT);
            } else {
                $no = $prefix . '001';
            }
            // 判断是否存在
            if (!static::query()->where('number', $no)->exists()) {
                return $no;
            }
        }
        logger()->warning('生成bug编号失败');
        return false;
    }

    // 编号前缀 部门+BUG 例：XSBUG202006005
    protected static function getNumberPrefix($model)
    {
        $dept = Department::query()->find($model->dept_id);
        if (empty($dept) || empty($dept->code)) {
            throw new InvalidParameterException('部门代码不能为空!');
        }
        return $dept->code . 'BUG' . date('Ym');
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection(self::media)->useDisk('pm');
    }

    public function getMediaCollectionName()
    {
        return self::media;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'pm_bugs_has_products');
    }

    public function reason()
    {
        return $this->belongsTo(BugReason::class, 'reason_id');
    }

    public function handlers()
    {
        return $this->hasMany(BugHandler::class);
    }

    // 审批日志
    public function examineLogs()
    {
        return $this->hasMany(BugExamineLog::class);
    }

    public function getStatus($status)
    {
        return BugStatus::getStatusDesc($status);
    }

    public function getExamineStatus($status)
    {
        return BugExamineStatus::getDesc($status);
    }

    public function bugAccept()
    {
        return $this->hasMany(BugAccept::class);
    }

    public function labels()
    {
        return $this->hasMany(BugLabel::class);
    }

    /**
     * 添加标签
     * @param $name
     * @param null $comment
     */
    public function addLabel($name, $comment = null)
    {
        if (!in_array($name, BugLabel::LABEL_NAMES)) return;
        if (is_null($comment)) {
            $comment = request()->input('comment', '') ?? '';
        }
        $user = Auth::user();
        $data = [
            'name'      => $name,
            'user_id'   => $user->id,
            'user_name' => $user->name,
            'comment'   => $comment,
        ];
        $this->labels()->updateOrCreate(['name' => $name], $data);
    }

    // 所属需求
    public function project()
    {
        return $this->belongsTo(Project::class, 'source_project_id');
    }

    // 所属项目
    public function demand()
    {
        return $this->belongsTo(Demand::class, 'source_demand_id');
    }

    // 发布的需求
    public function demands()
    {
        return $this->hasMany(Demand::class, 'source_bug_id');
    }

    // 发布的诉求
    public function appeals()
    {
        return $this->hasMany(Appeal::class, 'source_bug_id');
    }

    public function setOperationAccountAttribute($val)
    {
        $users = User::query()->whereIn('id', $val)->get();
        $users = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
            ];
        });
        $this->attributes['operation_account'] = json_encode($users->toArray());
    }

    public function setBrowserAttribute($val)
    {
        $this->attributes['browser'] = json_encode($val);
    }

    public function setLinksAttribute($val)
    {
        $this->attributes['links'] = json_encode($val);
    }

    /**
     * 日志描述
     * @param string $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        $userName = Auth::user()->name;
        if ($eventName == 'created') {
            return "由 {$userName} 创建";
        }
        return "由 {$userName} 编辑";
    }

    /**
     * 记录属性值变化
     * @param string $processingEvent
     * @return array
     */
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
            $changeFormat = $this->changeFormat($key, $item);
            $changes[] = [
                'name' => BugColumn::COLUMN_DESC[$key],
                'old'  => $changeFormat[0],
                'new'  => $changeFormat[1],
            ];
        });
        if ($relatedChanges = $this->getRelatedChanges()) {
            $changes = array_merge($changes, $relatedChanges);
        }
        $properties['changes'] = $changes;
        return $properties;
    }

    /**
     * @param $key
     * @param $value
     * @return array
     */
    public function changeFormat($key, $value)
    {
        if ($key == 'status') {
            $old = $this->getStatus($this->getOriginal($key));
            $new = $this->getStatus($value);
        } elseif ($key == 'examine_status') {
            $old = $this->getExamineStatus($this->getOriginal($key));
            $new = $this->getExamineStatus($value);
        } elseif ($key == 'operation_platform') {
            $old = OperationPlatform::getDesc($this->getOriginal($key));
            $new = OperationPlatform::getDesc($value);
        } elseif ($key == 'data_restore') {
            $old = BugDataRestore::getDesc($this->getOriginal($key));
            $new = BugDataRestore::getDesc($value);
        } elseif ($key == 'operation_account') {
            $oldValue = json_decode($this->getOriginal($key), true);
            $old = implode(',', collect($oldValue)->pluck('name')->toArray());

            $newValue = json_decode($value, true);
            $new = implode(',', collect($newValue)->pluck('name')->toArray());
        } elseif (in_array($key, ['browser', 'links'])) {
            $oldValue = json_decode($this->getOriginal($key), true);
            $old = is_array($oldValue) ? implode(',', $oldValue) : '';
            $new = implode(',', json_decode($value, true));
        } else {
            $old = $this->getOriginal($key);
            $new = $value;
        }
        return [$old, $new];
    }

    public function scopeDurationDate(Builder $builder, ...$data)
    {
        if ($data[0] != "") {
            $builder->where('start_time', ">=", trim($data[0]) . " 00:00:00");
        }

        if ($data[1] != "") {
            $builder->where('end_time', "<=", trim($data[1]) . " 23:59:59");
        }
        return $builder;
    }

    public function scopeKeyword(Builder $builder, $data)
    {
        $start = substr($data, 0, 1);
        $end = substr($data, -1);
        if ($start == "%" || $end == "%") {
            $builder->where(function ($query) use ($data) {
                $query->where('number', 'like', $data)
                    ->orWhere('description', 'like', $data)
                    ->orWhere('erp_bug_id', 'like', $data)
                    ->orWhere('erp_bug_number', 'like', $data);
            });
        } else {
            $builder->where(function ($query) use ($data) {
                $query->where('number', $data)
                    ->orWhere('description', $data)
                    ->orWhere('erp_bug_number', $data);
            });
        }
        return $builder;
    }

    public function scopeStatus(Builder $builder, ...$data)
    {
        $builder->whereIn('status', $data);
        return $builder;
    }

    private function getDiffDays($startTime, $endTime)
    {
        $dead_line = Carbon::parse($endTime);
        return Carbon::parse(Carbon::parse($startTime)->format("Y-m-d"))->diffInDays($dead_line, false);
    }

    public function getRemainingDaysAttribute()
    {
        if (is_null($this->expiration_date)) {
            return "";
        }
        if (in_array($this->status, [
            BugStatus::STATUS_TO_ASSIGN,
            // BugStatus::STATUS_TO_FINANCIAL_EXAMINE,
            // BugStatus::STATUS_TO_INTERNAL_CONTROL_EXAMINE,
            BugStatus::STATUS_REVOCATION])) {
            return '';
        }
        if (!is_null($this->finish_time) && in_array($this->status, [BugStatus::STATUS_COMPLETED, BugStatus::STATUS_NO_HANDLE])) {
            $day = $this->getDiffDays($this->finish_time, $this->expiration_date);
        } else if (!is_null($this->submit_time) && $this->status == BugStatus::STATUS_TO_REEXAMINE) {
            $day = $this->getDiffDays($this->submit_time, $this->expiration_date);
        } else {
            $day = $this->getDiffDays(Carbon::now(), $this->expiration_date);
        }
        return $day;
    }

    public function getRemainingDaysTypeAttribute()
    {
        $type = 0; // 进行中
        if (!empty($this->finish_time) && in_array($this->status, [BugStatus::STATUS_COMPLETED, BugStatus::STATUS_NO_HANDLE])) {
            $type = 2; // 已完成
        } else if (!empty($this->submit_time) && $this->status == BugStatus::STATUS_TO_REEXAMINE) {
            $type = 1; // 已提交
        }
        return $type;
    }
}
