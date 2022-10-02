<?php

namespace App\ProjectManage\Models;

use App\Enums\ProjectManage\DemandLinksType;
use App\Enums\ProjectManage\DemandStatus;
use App\Enums\ProjectManage\ProductStatus;
use App\Models\User;
use App\Support\QueryBuilder\Filters\MayFilter;
use App\Support\QueryBuilder\Filters\MustFilter;
use App\Traits\AttentionTrait;
use App\Traits\CreatedAtFilter;
use App\Traits\DateFormatTrait;
use App\Traits\HasSourceProjectTrait;
use App\Traits\IsUpdateTrait;
use App\Traits\KeyWordFilter;
use App\Traits\ModelsTrait;
use App\Traits\NumberTrait;
use App\Traits\PolicyTrait;
use App\Traits\ProductTrait;
use App\Traits\SearchProduct;
use App\Traits\StatusLogTrait;
use App\Traits\Task\RemainingDaysTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Demand extends Model implements HasMedia
{
    use ModelsTrait,HasMediaTrait,LogsActivity,StatusLogTrait,IsUpdateTrait, AttentionTrait, NumberTrait, RemainingDaysTrait;
    use SearchProduct, CreatedAtFilter, KeyWordFilter, PolicyTrait, HasSourceProjectTrait, ProductTrait, DateFormatTrait;

    public $docsMedia = 'demands';
    protected $table = 'pm_demands';
    protected $fillable = [
        'status', 'priority', 'expiration_date', 'source_project_id', 'source_project_name', 'name', 'content', 'number', 'level',
        'promulgator_id', 'promulgator_name', 'confirmed', 'share_address', 'start_time', 'finish_time','principal_user_id','principal_user_name', 'updated_at', 'source_bug_id',
    ];
    protected $appends = ['is_updated', 'status_desc', 'remaining_days', 'remaining_days_type'];
    protected $casts = [
        'share_address' => 'json'
    ];
    protected static $logName = 'operation_log';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at', 'start_time', 'finish_time' ,'source_project_id', 'verify_user_id', 'verify_time','confirmed', 'principal_user_id',];
    protected static $recordEvents = ['created','updated'];
    protected const PREFIX_STR = "XQ";
    protected $showSubmitTime = false;
    protected $notShowRemainStatus = [
      DemandStatus::STATUS_COMPLETED,
      DemandStatus::STATUS_REVOCATION,
      DemandStatus::STATUS_REJECTED
    ];
    public $cacheName = 'demands';
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->number) {
                $model->number = static::findAvailableNumber();
                if (!$model->number) {
                    return false;
                }
            }
        });
    }
    // 需求的研发环节
    public function demandLinks()
    {
        return $this->hasMany(DemandLink::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'pm_demands_has_products');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'source_project_id', 'id');
    }

    public function getDocsAttribute()
    {
        return $this->getMedia($this->docsMedia);
    }

    public function appeals()
    {
        return $this->hasMany(Appeal::class);
    }

    public function promulgatorUser()
    {
        return $this->belongsTo(User::class, 'promulgator_id')->withTrashed();
    }

    public function getLabels()
    {
        $labels = [];
        $appeal = $this->appeals;
        if (is_null($appeal)) return [];
        $appeal->map(function ($item) use (&$labels) {
            $labels = array_merge($labels, $item->labels()->get()->toArray());
        });
        $labels = collect($labels)->unique('id')->toArray();
        return $labels;
    }

    public function getIsAttentionAttribute()
    {
        $res = $this->attentionAble()->where('user_id', Auth::id())->get();
        return $res->isNotEmpty();
    }

    public function getTaskNumAttribute()
    {
        $count = 0;
        $design_count = $this->designSubtasks()->count();
        $dev_count = $this->devSubtasks()->count();
        $test_count = $this->testSubtasks()->count();
        return $count + $design_count + $dev_count + $test_count;
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection($this->docsMedia)
            ->useDisk('pm');
    }

    public function changes()
    {
        return $this->morphMany(ActivityLog::class, 'subject')->select('description','created_at','subject_id','causer_id','properties');
    }

    protected function getColsCNDesc($val)
    {
        switch ($val) {
            case 'priority':
                return '优先级';
            case 'expiration_date':
                return '截至日期';
            case 'source_project_name':
                return '项目来源名称';
            case "name":
                return '需求名称';
            case "content":
                return '需求内容';
            case "share_address":
                return "URL/共享地址";
            case "status":
                return "项目状态";
            case "principal_user_name":
                return "产品负责人";
            default:
                return "其他信息";
        }
    }

    /**
     * Description 的值
     * @param string $eventName
     * @return string
     */
    protected function getDescriptionForEvent(string $eventName): string
    {
        switch ($eventName) {
            case 'created':
                return '由' . $this->promulgator_name . '创建';
            case 'updated':
                return '由' . Auth::user()->name . '编辑';
        }
    }

    /**
     * 记录的数据
     * @param $eventName
     * @return array
     */
    protected function attributeValuesToBeLogged($eventName)
    {
        if ($eventName == 'created'){
            return [];
        }

        $properties['attributes'] = static::logChanges(
            $this->exists
                ? $this->fresh() ?? $this
                : $this
        );

        if (static::eventsToBeRecorded()->contains('updated') && $eventName == 'updated') {
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
        collect($this->getDirty())->except(self::$logAttributesToIgnore)->map(function ($item,$key)use(&$changes){
            $changes[] = [
                'old' => $key == 'status' ? $this->getStatus($this->getOriginal($key)) : $this->getOriginal($key),
                'new' => $key == 'status' ? $this->getStatus($item) : $item,
                'name' => $this->getColsCNDesc($key)
            ];
        });
        $relateChanges = $this->getRelateChanges();
        $changes = array_merge($changes, $relateChanges);
        $properties['changes'] = $changes;
        return $properties;
    }

    public function getStatus($val)
    {
        return DemandStatus::getStatusDesc($val);
    }

    public function designSubtasks()
    {
        return $this->hasManyThrough(DesignSubTask::class,DesignTask::class, 'demand_id','task_id', 'id', 'id');
    }

    public function devSubtasks()
    {
        return $this->hasManyThrough(DevSubTask::class,DevTask::class, 'demand_id','task_id', 'id', 'id');
    }

    public function testSubtasks()
    {
        return $this->hasManyThrough(TestSubTask::class,TestTask::class, 'demand_id','task_id', 'id', 'id');
    }

    public function designTasks()
    {
        return $this->hasMany(DesignTask::class);
    }

    public function devTasks()
    {
        return $this->hasMany(DevTask::class);
    }

    public function testTasks()
    {
        return $this->hasMany(TestTask::class);
    }

    public function designPart()
    {
        return $this->hasManyThrough(DesignPart::class,DesignTask::class, 'demand_id','task_id', 'id', 'id');
    }

    public function frontendTasks()
    {
        return $this->hasMany(FrontendTask::class);
    }

    public function frontendSubtasks()
    {
        return $this->hasManyThrough(FrontendSubTask::class, FrontendTask::class, 'demand_id', 'task_id', 'id', 'id');
    }

    public function mobileTasks()
    {
        return $this->hasMany(MobileTask::class);
    }

    public function mobileSubTasks()
    {
        return $this->hasManyThrough(MobileSubTask::class, MobileTask::class, 'demand_id', 'task_id', 'id', 'id');
    }

    // 预计纳入版本
    public function versions()
    {
        return $this->belongsToMany(ReleaseVersion::class, 'pm_demands_has_versions');
    }

    /**
     * 与项目有关联的人 id array
     * @return \Illuminate\Support\Collection
     */
    public function relateUsers()
    {
        $users = [];
        $users[] = $this->principal_user_id; // 产品负责人
        $users[] = $this->promulgator_id;   // 发布人
        $users[] = $this->verify_user_id;  // 审核人
        // 关注的人
        $this->attentionAble()->get()->map(function ($item)use(&$users){
            $users[] = $item->user_id;
        });
        // 各项子任务的发布人，负责人
        $this->designSubtasks()->get()->map(function ($item)use(&$users){
            $users[] = $item->handler_id;
        });

        $this->devSubtasks()->get()->map(function ($item)use(&$users){
            $users[] = $item->handler_id;
        });

        $this->testSubtasks()->get()->map(function ($item)use(&$users){
            $users[] = $item->handler_id;
        });
        return collect($users)->unique();
    }

    protected function getRelateChanges()
    {
        $key = 'demand_id_' . $this->id . '_user_id_' . Auth::id();
        $changes = $this->getUpdatedChanges($key);
        if (request()->has('product_id')){
            // 原始关联产品
            $oldProducts = $this->products()->wherePivot('product_type', '!=', ProductStatus::TypeCategory)->get();
            $oldProductNames = implode(',', $oldProducts->pluck('name')->toArray());

            // 新传过来的产品类别
            $product = Product::query()->find(request()->product_id);
            $productLine = $product->parent;
            $modulesIds = collect(request()->product_modules)->map(function ($item) {
                return $item['module_id'];
            });
            $productModules = Product::query()->whereIn('id', $modulesIds->toArray())->get();
            $newProducts = collect([$productLine])->merge([$product])->merge($productModules);
            $newProductNames = implode(',', $newProducts->pluck('name')->toArray());

            if ($oldProductNames != $newProductNames) {
                $changes[] = [
                    'name' => '所属产品或模块',
                    'old' => $oldProductNames,
                    'new' => $newProductNames,
                ];
            }
        }
        return $changes;
    }

    protected function getUpdatedCacheInstance()
    {
        return Cache::tags(['pm','updateInfo','demand']);
    }

    public function updateCacheOfUpdated(string $key, array $newChanges)
    {
        $changes = $this->getUpdatedChanges($key);
        $changes[] = $newChanges;
        $this->getUpdatedCacheInstance()->put($key, json_encode($changes), 600);
    }

    public function forgetUpdatedCache($key)
    {
        $this->getUpdatedCacheInstance()->forget($key);
    }

    public function getUpdatedChanges($key)
    {
        if (Route::currentRouteName() == 'pm.demand.update.public'){
            $changes = $initChanges = $this->getUpdatedCacheInstance()->get($key,[]);
            if ($changes != []){
                $changes = json_decode($changes);
            }
            return $changes;
        }
        return [];
    }

    public function scopeDesignManager(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchDemandLinks($builder, $val, $type, DemandLinksType::TYPE_DESIGN, $searchType);
    }

    public function scopeDevManager(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchDemandLinks($builder, $val, $type, DemandLinksType::TYPE_DEVELOP, $searchType);
    }

    public function scopeTestManager(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchDemandLinks($builder, $val, $type, DemandLinksType::TYPE_TEST, $searchType);
    }

    public function scopeFrontEndManager(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchDemandLinks($builder, $val, $type, DemandLinksType::TYPE_FRONTEND, $searchType);
    }

    public function scopeMobileManager(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchDemandLinks($builder, $val, $type, DemandLinksType::TYPE_MOBILE, $searchType);
    }

    protected function searchDemandLinks(Builder $builder, $val, $type, $demandLink_type, $searchType)
    {
        if ($searchType == 'may'){
            $builder = $builder->orWhereHas('demandLinks', function($query)use($type, $val, $demandLink_type){
                $query->where($query->qualifyColumn('type'), $demandLink_type)->where(function ($q)use($type, $val){
                    (new MayFilter())->getSqlByTypeAndVal($q, $type, $val, $q->qualifyColumn('principal_user_id'));
                });
            });
        } else {
            $builder = $builder->WhereHas('demandLinks', function($query)use($type, $val, $demandLink_type){
                $query->where($query->qualifyColumn('type'), $demandLink_type)->where(function ($q)use($type, $val){
                    (new MustFilter())->getSqlByTypeAndVal($q, $type, $val, $q->qualifyColumn('principal_user_id'));
                });
            });
        }
        return $builder;
    }

    public function getPriorityAttribute($val)
    {
        if($val == 0) {
            return "";
        }
        return $val;
    }
}
