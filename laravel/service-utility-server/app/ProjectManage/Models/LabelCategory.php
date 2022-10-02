<?php

namespace App\ProjectManage\Models;

use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;

class LabelCategory extends Model
{
    use DateFormatTrait;

    protected $table = 'pm_label_categories';

    protected $fillable = ['name', 'is_open', 'sort', 'style'];

    public function scopeIsOpen($query)
    {
        return $query->where('is_open', 1);
    }

    public function labels()
    {
        return $this->hasMany(Label::class);
    }
}
