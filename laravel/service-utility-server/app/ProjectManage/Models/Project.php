<?php

namespace App\ProjectManage\Models;

use App\Enums\ProjectManage\ProjectStatus;
use App\Traits\AttentionTrait;
use App\Traits\DateFormatTrait;
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

class Project extends Model implements HasMedia
{
    use ModelsTrait, HasMediaTrait, StatusLogTrait, AttentionTrait, NumberTrait, PolicyTrait, RemainingDaysTrait;
    use SearchProduct, LogsActivity, ProductTrait, DateFormatTrait;

    protected $table = 'pm_projects';
    protected $fillable = ['number', 'name', 'type', 'principal_user_id', 'principal_user_name', 'expiration_date', 'contents', 'status', 'shared_address', 'promulgator_id', 'promulgator_name', 'comment', 'level', 'difficulty'];

    protected $appends = ['remaining_days_type','remaining_days', 'status_desc',];
    protected $mediaName = 'project';

    protected const PREFIX_STR = "XM";

    protected $showSubmitTime = false;
    protected $notShowRemainStatus = [];

    protected $casts = [
        'shared_address' => 'json'
    ];

    protected static $logName = 'operation_log';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at', 'finish_time', 'principal_user_id' ];
    protected static $recordEvents = ['created','updated'];

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

    public function products()
    {
        return $this->belongsToMany(Product::class, 'pm_projects_has_products');
    }

    // 项目对应IT产品的负责人
    public function projectPrincipals()
    {
        return $this->hasMany(ProjectPrincipals::class, 'project_id', 'id');
    }

    public function demands()
    {
        return $this->hasMany(Demand::class, 'source_project_id', 'id');
    }

    public function designTasks()
    {
        return $this->hasMany(DesignTask::class, 'source_project_id', 'id');
    }

    public function devTasks()
    {
        return $this->hasMany(DevTask::class, 'source_project_id', 'id');
    }

    public function testTasks()
    {
        return $this->hasMany(TestTask::class, 'source_project_id', 'id');
    }

    public function designSubtasks()
    {
        return $this->hasManyThrough(DesignSubTask::class,DesignTask::class, 'source_project_id','task_id', 'id', 'id');
    }

    public function devSubtasks()
    {
        return $this->hasManyThrough(DevSubTask::class,DevTask::class, 'source_project_id','task_id', 'id', 'id');
    }

    public function testSubtasks()
    {
        return $this->hasManyThrough(TestSubTask::class,TestTask::class, 'source_project_id','task_id', 'id', 'id');
    }

    public function getStatus($val)
    {
        return ProjectStatus::getStatusDesc($val);
    }

    public function getIsAttention()
    {
        $res = $this->attentionAble()->where('user_id', Auth::id())->get();
        return $res->isNotEmpty();
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection($this->media)->useDisk('pm');
        $this->addMediaCollection('project_summary')->singleFile()->useDisk('pm');
    }

    public function getProjectMedia()
    {
        return $this->mediaName;
    }

    public function setSharedAddressAttribute($val)
    {
        $this->attributes['shared_address'] = is_array($val) ? json_encode($val) : $val;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getRelateUsers()
    {
        $users = [];
        //关注改项目的人
        $this->attentionAble()->get()->map(function ($item) use (&$users) {
            $users[] = $item->user_id;
        });
        // 各类负责人
        $this->projectPrincipals()->get()->map(function ($item) use (&$users) {
            $users[] = $item->user_id;
        });
        // 主负责人
        $users[] = $this->principal_user_id;
        // 发布人
        $users[] = $this->promulgator_id;
        $users = collect($users)->unique();
        return $users;
    }

    public function appeals()
    {
        return $this->hasMany(Appeal::class, 'source_project_id');
    }

    /**
     * 参与的
     * @param Builder $builder
     * @param $data
     * @return Builder
     */
    public function scopeParticipant(Builder $builder, $data)
    {
        $builder->where(function($query)use($data){
            $query->where('principal_user_id', $data)
                ->orWhere('promulgator_id', $data)
                ->orWhereHas('projectPrincipals', function ($q) use ($data) {
                    $q->where($q->qualifyColumn('user_id'), $data);
                })
                ->orWhereHas('appeals', function ($q)use($data){
                    $q->where($q->qualifyColumn('principal_user_id'), $data)->orWhere('promulgator_id', $data);
                })
                ->orWhereHas('demands', function ($q)use($data){
                    $q->where($q->qualifyColumn('principal_user_id'), $data)->orWhere('promulgator_id', $data);
                })
                ->orWhereHas('designTasks', function ($q)use($data){
                    $q->where($q->qualifyColumn('principal_user_id'), $data)
                        ->orWhere($q->qualifyColumn('promulgator_id'), $data)
                        ->orWhereHas('parts', function ($q1)use($data){
                           $q1->where($q1->qualifyColumn('principal_user_id'), $data)->orWhereHas('subTasks', function ($q2)use($data){
                              $q2->where($q2->qualifyColumn('handler_id'), $data);
                           });
                        });
                })
                ->orWhereHas('devTasks', function ($q)use($data){
                    $q->where($q->qualifyColumn('principal_user_id'), $data)
                        ->orWhere($q->qualifyColumn('promulgator_id'), $data)
                        ->orWhereHas('subTasks', function ($q1)use($data){
                            $q1->where($q1->qualifyColumn('handler_id'), $data);
                        });
                })
                ->orWhereHas('testTasks', function ($q)use($data){
                    $q->where($q->qualifyColumn('principal_user_id'), $data)
                        ->orWhere($q->qualifyColumn('promulgator_id'), $data)
                        ->orWhereHas('subTasks', function ($q1)use($data){
                            $q1->where($q1->qualifyColumn('handler_id'), $data);
                        });
                });
        });
        return $builder;
    }

    /**
     * 关键字 查询name/number
     * @param Builder $builder
     * @param $data
     * @return Builder
     */
    public function scopeKeyword(Builder $builder, $data)
    {
        $start = substr($data, 0 ,1);
        $end = substr($data, -1);
        if ($start == "%" || $end == "%"){
            $builder->where(function ($query)use ($data){
                $query->orWhere('name', 'like', $data)->orWhere('number', 'like', $data);
            });
        } else {
            $builder->where(function ($query)use ($data){
                $query->orWhere('name', $data)->orWhere('number', $data);
            });
        }
        return $builder;
    }


    protected function getRelateChanges()
    {

        $key = 'project_id_' . $this->id . '_user_id_' . Auth::id();
        $changes = $this->getUpdatedChanges($key);
        // 产品关联
        if ($newProduct = Product::find(request()->product_id)) {
            $oldProducts = $this->products()->get();
            if (!$oldProducts->pluck('id')->contains($newProduct->id)) {
                $changes[] = [
                    'name' => '所属产品或模块',
                    'old' => implode(',', $oldProducts->pluck('name')->toArray()),
                    'new' => $newProduct->name,
                ];
            }
        }
        return $changes;
    }

    protected function getUpdatedCacheInstance()
    {
        return Cache::tags(['pm','updateInfo','project']);
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
        if (Route::currentRouteName() == 'pm.projects.edit.public'){
            $changes = $initChanges = $this->getUpdatedCacheInstance()->get($key,[]);
            if ($changes != []){
                $changes = json_decode($changes);
            }
            return $changes;
        }
        return [];
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

    /**
     * @param $col
     */
    public function getColsCNDesc($col){
        switch ($col){
            case 'name':
                return "项目名称";
            case "principal_user_name":
                return "项目负责人名称";
            case "expiration_date":
                return "项目截止日期";
            case "contents":
                return "项目描述";
            case "status":
                return "项目状态";
            case "shared_address":
                return "共享地址或URL地址";
            case "comment":
                return "项目备注";
            case "level":
                return "项目级别";
            case "difficulty":
                return "项目难度";
        }
    }

    public function changes()
    {
        return $this->morphMany(ActivityLog::class, 'subject')->select('description','created_at','subject_id','causer_id','properties')->where('log_name','operation_log');
    }
}
