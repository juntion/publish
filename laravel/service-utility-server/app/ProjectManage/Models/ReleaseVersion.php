<?php

namespace App\ProjectManage\Models;

use App\Enums\ProjectManage\Releases\ReleaseVersionStatus;
use App\Models\BaseModel;
use App\Traits\PolicyTrait;
use App\Traits\StatusLogTrait;

/**
 * 发版版本号
 */
class ReleaseVersion extends BaseModel
{
    use StatusLogTrait, PolicyTrait;

    protected $table = 'pm_release_versions';

    protected $fillable = [
        'release_product_id', 'main_version', 'second_version', 'third_version', 'status', 'creator_id', 'creator_name',
        'expected_release_test_time', 'release_test_user_id', 'release_test_user_name', 'release_test_time', 'release_test_comment',
        'expected_release_online_time', 'release_online_user_id', 'release_online_user_name', 'release_online_time', 'release_online_comment',
        'feature_count',
    ];

    protected $appends = ['status_desc', 'full_version'];

    // 所属发版产品
    public function product()
    {
        return $this->belongsTo(ReleaseProduct::class, 'release_product_id');
    }

    // 纳入版本的设计子任务
    public function designSubTasks()
    {
        return $this->hasMany(DesignSubTask::class);
    }

    // 纳入版本的开发子任务
    public function devSubTasks()
    {
        return $this->hasMany(DevSubTask::class);
    }

    public function mobileSubTasks()
    {
        return $this->hasMany(MobileSubTask::class);
    }

    public function frontendSubTasks()
    {
        return $this->hasMany(FrontendSubTask::class);
    }

    public function getStatus($status)
    {
        return ReleaseVersionStatus::getStatusDesc($status);
    }

    // 完整版本号
    public function getFullVersionAttribute()
    {
        return "V{$this->main_version}.{$this->second_version}.{$this->third_version}";
    }

    /**
     * 版本管理员ID集合
     * @return array
     */
    public function adminIds()
    {
        return $this->product->admins->pluck('user_id')->toArray();
    }

    /**
     * 维护功能点个数
     * @param $oldId
     * @param $newId
     */
    public static function changeFeatureCount($oldId, $newId)
    {
        if ($oldId) {
            ReleaseVersion::query()->find($oldId)->decrement('feature_count');
        }
        if ($newId) {
            ReleaseVersion::query()->find($newId)->increment('feature_count');
        }
    }

    public function scopeOrderByVersion($query)
    {
        return $query->orderBy('main_version', 'desc')->orderBy('second_version', 'desc')->orderBy('third_version', 'desc');
    }
}
