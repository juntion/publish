<?php

namespace App\Models\Sidebar;

use App\Models\Page;
use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;

class SidebarCategory extends Model
{
    use DateFormatTrait;

    protected $fillable = ['parent_id', 'sidebar_template_id', 'name', 'comment', 'locale', 'icon', 'sort'];

    public function templates()
    {
        return $this->belongsTo(SidebarTemplate::class, 'sidebar_template_id');
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class, 'sidebar_category_has_pages')
            ->orderBy('sidebar_category_has_pages.sort', 'desc')
            ->withPivot('sort');
    }

    public function getChildrenAttribute()
    {
        return SidebarCategory::query()->where('parent_id', $this->id)
            ->orderBy('sort', 'desc')->with('pages')->get();
    }
}
