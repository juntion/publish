<?php

namespace App\Models;

use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes, DateFormatTrait;

    protected $fillable = ['parent_id', 'name', 'locale', 'is_base', 'path', 'code'];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Department $model) {
            $model->path  = $model->getNewPath();
        });

        static::updating(function (Department $model) {
            if ($model->isDirty('parent_id')) {
                $model->path = $model->getNewPath();
            }
        });

        static::updated(function (Department $model) {
            if ($model->isDirty('path')) {
                $children = $model->children;
                if ($children->isNotEmpty()) {
                    // 更新子部门的 path
                    foreach ($children as $child) {
                        $child->update(['path' => $model->path . $model->id . '-']);
                    }
                }
            }
        });
    }

    public function getNewPath()
    {
        // 如果创建的是一个根类目
        if ($this->parent_id == 0) {
            // 将 path 设为 -
            return '-';
        } else {
            // 将 path 值设为父类目的 path 追加父类目 ID 以及最后跟上一个 - 分隔符
            return $this->parent->path . $this->parent_id . '-';
        }
    }

    public function parent()
    {
        return $this->belongsTo(Department::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_departments');
    }

    public function getTopIdAttribute()
    {
        if ($top = $this->top()) {
            return $top->id;
        }
        return $this->id;
    }

    public function top()
    {
        if ($this->is_base == 1) {
            return $this;
        }
        return Department::query()
            ->whereIn('id', $this->parent_ids)
            ->where('is_base', 1)
            ->first();
    }

    public function getChildrenAttribute()
    {
        return Department::query()->where('parent_id', $this->id)->get();
    }

    /**
     * 获取所有祖先类目的 ID 值
     * @return array
     * @author: King
     * @version: 2020/4/28 18:25
     */
    public function getParentIdsAttribute()
    {
        // trim($str, '-') 将字符串两端的 - 符号去除
        // explode() 将字符串以 - 为分隔切割为数组
        // 最后 array_filter 将数组中的空值移除
        return array_filter(explode('-', trim($this->path, '-')));
    }

    public function isBase(): bool
    {
        return $this->is_base == 1;
    }
}
