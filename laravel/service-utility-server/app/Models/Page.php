<?php

namespace App\Models;

use App\Models\Sidebar\SidebarCategory;
use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use DateFormatTrait;

    protected $fillable = ['name', 'comment', 'locale'];

    public function scopeHomepage($query)
    {
        return $query->where('type', 1);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_homepages');
    }

    public function sidebarCategory()
    {
        return $this->belongsToMany(SidebarCategory::class, 'sidebar_category_has_pages');
    }

    public function forbidUsers()
    {
        return $this->belongsToMany(User::class, 'user_forbid_pages');
    }

    /**
     * 创建页面数据
     * @param array $attributes
     */
    public static function createNotExists(array $attributes)
    {
        $pages = static::query()->get(['name', 'guard_name'])
            ->map(function ($item) {
                return $item['name'] . $item['guard_name'];
            })->toArray();

        foreach ($attributes as $attr) {
            $attr['guard_name'] = $attr['guard_name'] ?? config('app.guard');
            $attr['locale'] = !empty($attr['locale']) ? json_encode($attr['locale']) : null;

            if (in_array($attr['name'] . $attr['guard_name'], $pages)) {
                continue;
            }

            $data = collect($attr)->only(['name', 'comment', 'guard_name', 'locale', 'type', 'route', 'route_name']);
            static::create($data->toArray());
        }
    }
}
