<?php

namespace App\ProjectManage\Models;

use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use DateFormatTrait;

    protected $table = 'pm_labels';

    protected $fillable = ['label_category_id', 'name', 'is_open', 'sort', 'comment', 'style'];

    public function scopeIsOpen($query)
    {
        return $query->where('is_open', 1);
    }

    public function appeals()
    {
        return $this->belongsToMany(Appeal::class, 'pm_appeals_has_labels');
    }

    // 所属标签分类
    public function category()
    {
        return $this->belongsTo(LabelCategory::class, 'label_category_id');
    }

    // 覆盖 style 字段
    public function getStyleAttribute($value)
    {
        if (empty($value)) {
            $category = $this->category()->first();
            return $category ? $category->style : '';
        }
        return $value;
    }
}
