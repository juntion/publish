<?php

namespace App\Models;

use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Position extends Model
{
    use DateFormatTrait;

    protected $fillable = ['name', 'comment', 'locale'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_positions');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // 如果不存在此子系统则创建
    public static function createNotExists($attributes)
    {
        $attributes = $attributes instanceof Collection ? $attributes->toArray() : $attributes;

        if (is_array($attributes)) {
            $allPositions = self::all();
            $positions = collect($allPositions)->mapWithKeys(function ($item, $key) {
                return [$item['name'] => $key];
            })->toArray();
            foreach ($attributes as $attribute) {
                $attribute['locale'] = !empty($attribute['locale']) ? json_encode($attribute['locale']) : null;
                $posts = $attribute['posts'];
                if (!isset($positions[$attribute['name']])) {
                    $data = self::filterAttributes($attribute);
                    // 保存职位，并关联岗位post
                    $position = static::create($data);
                    if ($posts) {
                        Post::createNotExists($posts, $position->id);
                    }
                }
            }
        }
    }

    public static function filterAttributes(array $attributes)
    {
        $columns = ['number', 'name', 'comment', 'locale', 'is_system'];
        $data = [];
        foreach ($attributes as $key => $item) {
            if (in_array($key, $columns)) {
                $data[$key] = $item;
            }
        }
        return $data;
    }
}
