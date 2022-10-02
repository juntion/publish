<?php

namespace App\Models\Sidebar;

use App\Models\User;
use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;

class SidebarTemplate extends Model
{
    use DateFormatTrait;

    protected $fillable = ['name', 'comment', 'locale', 'guard_name'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_sidebar_templates');
    }

    public function categories()
    {
        return $this->hasMany(SidebarCategory::class)->orderBy('sort', 'desc');
    }
}
