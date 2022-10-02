<?php

namespace App\ProjectManage\Models;

use App\Enums\ProjectManage\AppealColumn;
use App\Enums\ProjectManage\AppealStatus;
use App\Enums\ProjectManage\TeamMemberType;
use App\Enums\ProjectManage\TeamType;
use App\Traits\ActivityLogTrait;
use App\Traits\AttentionTrait;
use App\Traits\CreatedAtFilter;
use App\Traits\DateFormatTrait;
use App\Traits\IsUpdateTrait;
use App\Traits\KeyWordFilter;
use App\Traits\ModelsTrait;
use App\Traits\PolicyTrait;
use App\Traits\ProductTrait;
use App\Traits\RelatedChangesTrait;
use App\Traits\SearchProduct;
use App\Traits\StatusLogTrait;
use App\Traits\Task\RemainingDaysTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Appeal extends Model implements HasMedia
{
    use HasMediaTrait, ModelsTrait, StatusLogTrait, ActivityLogTrait, AttentionTrait, IsUpdateTrait, RemainingDaysTrait;
    use LogsActivity, RelatedChangesTrait, SearchProduct, KeyWordFilter, CreatedAtFilter, PolicyTrait, ProductTrait;
    use DateFormatTrait;

    protected $table = 'pm_appeals';

    protected $fillable = [
        'number', 'name', 'content', 'brief', 'type', 'is_urgent', 'is_important', 'source_project_id',
        'source_project_name', 'expiration_date', 'status', 'dept_id', 'dept_name', 'promulgator_id', 'promulgator_name',
        'principal_user_id', 'principal_user_name', 'follower_id', 'follower_name', 'follow_time', 'follow_type',
        'verify_user_id', 'verify_user_name', 'verify_time', 'comment', 'origin_id', 'demand_id', 'questions', 'crux',
        'start_time', 'finish_time', 'comment_follower', 'source_bug_id',
    ];

    protected $casts = [
        'questions' => 'json',
    ];

    protected $appends = ['is_updated', 'remaining_days_type', 'remaining_days', 'status_desc',];

    // 附件保存的 collection_name
    const media = 'appeal';
    public $cacheName = 'appeals';

    protected static $logName = 'operation_log';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at', 'start_time', 'finish_time'];
    protected static $recordEvents = ['created', 'updated'];
    protected $showSubmitTime = false;
    protected $notShowRemainStatus = [
        AppealStatus::STATUS_COMPLETED,
        AppealStatus::STATUS_REJECTED,
        AppealStatus::STATUS_REVOCATION
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->number) {
                $model->number = static::findAvailableNo();
                if (!$model->number) {
                    return false;
                }
            }
        });
    }

    // 生成诉求编号
    public static function findAvailableNo()
    {
        // 诉求编号；SQ+yyyy/mm/dd+001；eg: SQ20191113001
        $prefix = 'SQ' . date('Ymd');
        for ($i = 0; $i < 10; $i++) {
            $lastAppeal = static::query()->where('created_at', '>=', date('Y-m-d 00:00:00'))
                ->where('origin_id', 0) // 没有被拆解过的
                ->orderBy('id', 'desc')->first();
            if ($lastAppeal) {
                if (Str::contains($lastAppeal->number, '-')) {
                    $lastAppeal->number = explode('-', $lastAppeal->number)[0];
                }
                $lastNo = substr($lastAppeal->number, -3);
                $no = $prefix . str_pad((intval($lastNo) + 1), 3, '0', STR_PAD_LEFT);
            } else {
                $no = $prefix . '001';
            }
            // 判断是否存在
            if (!static::query()->where('number', $no)->exists()) {
                return $no;
            }
        }
        logger()->warning('生成诉求编号失败');
        return false;
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection(self::media)->useDisk('pm');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'pm_appeals_has_products');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'pm_appeals_has_labels');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'source_project_id');
    }

    public function demand()
    {
        return $this->belongsTo(Demand::class);
    }

    public function getStatus($status)
    {
        return AppealStatus::getStatusDesc($status);
    }

    public function getMediaCollectionName()
    {
        return self::media;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function relateUsers()
    {
        $users = [];
        $users[] = $this->principal_user_id; // 产品负责人
        $users[] = $this->promulgator_id;   // 发布人
        $users[] = $this->follower_id;   // 跟进人
        $users[] = $this->verify_user_id;  // 审核人
        // 关注的人
        $this->attentionAble()->get()->map(function ($item) use (&$users) {
            $users[] = $item->user_id;
        });
        return collect($users)->filter()->unique()->reject(function ($item) {
            return $item == Auth::id();
        });
    }

    /**
     * 所属产品线（产品或产品模块）中，绑定的产品负责人或产品成员
     */
    public function canApplyUsers()
    {
        $result = [];
        $products = $this->products;
        $products->each(function (Product $product) use (&$result) {
            $teams = $product->teams->where('type', TeamType::TYPE_PRODUCT);
            $result = array_merge($result, $teams->pluck('user_id')->toArray());

            $teams->each(function (Team $team) use (&$result) {
                $members = $team->members->where('type', TeamMemberType::TYPE_PRODUCT);
                $result = array_merge($result, $members->pluck('user_id')->toArray());
            });
            unset($product->teams);
        });
        return collect($result)->unique()->toArray();
    }

    /**
     * 日志描述
     * @param string $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        $currentRoute = Route::currentRouteName();
        if ($currentRoute){
            $userName = Auth::user()->name;
            if ($eventName == 'created') {
                return "由 {$userName} 创建";
            }
            if (Str::contains($currentRoute, 'appeals.update')) {
                return "由 {$userName} 编辑";
            }
            if (Str::contains($currentRoute, 'appeals.follow')) {
                return "由 {$userName} 指派给 {$this->follower_name}";
            }
            if (Str::contains($currentRoute, 'appeals.disassemble')) {
                return "由 {$userName} 拆解";
            }
            if (Str::contains($currentRoute, 'appeals.revocation')) {
                return "由 {$userName} 撤销";
            }
            if (Str::contains($currentRoute, 'appeals.applyCancel')) {
                return "由 {$userName} 取消认领";
            }
            if (Str::contains($currentRoute, 'appeals.apply')) {
                return "由 {$userName} 认领";
            }
            if (Str::contains($currentRoute, 'appeals.verify')) {
                return "由 {$userName} 审核";
            }
            if (Str::contains($currentRoute, 'appeals.createDemand')) {
                return "由 {$userName} 立项";
            }
            if (Str::contains($currentRoute, 'appeals.cancelDemand')) {
                return "由 {$userName} 取消立项";
            }
            if (Str::contains($currentRoute, 'appeals.transfer')) {
                return "由 {$userName} 转移";
            }
            return "由 {$userName} 编辑";
        }
        return "";
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
            $changes[] = [
                'name' => AppealColumn::COLUMN_DESC[$key],
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

    public function scopeIsImportant(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        if ($searchType == 'may') {
            switch ($val) {
                case 1 :
                    $builder->orWhere(function ($query) use ($val) {
                        $query->where('is_urgent', 1);
                    });
                    break;
                case 2:
                    $builder->orWhere(function ($query) use ($val) {
                        $query->where('is_important', 1);
                    });
                    break;
                case 3:
                    $builder->orWhere(function ($query) use ($val) {
                        $query->where('is_urgent', 1)->where('is_important', 1);
                    });
                    break;
            }
        } else {
            switch ($val) {
                case 1 :
                    $builder->where('is_urgent', 1);
                    break;
                case 2:
                    $builder->where('is_important', 1);
                    break;
                case 3:
                    $builder->where('is_urgent', 1)->where('is_important', 1);
                    break;
            }
        }
        return $builder;
    }

    /**
     * 是否关注
     * @return mixed
     */
    public function getIsAttention()
    {
        $res = $this->attentionAble()->where('user_id', Auth::id())->get();
        return $res->isNotEmpty();
    }

    public function getFollowerIdAttribute($val)
    {
        return $val == 0 ? '' : $val;
    }
}
