<?php

namespace App\Models;

use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Post extends Model
{
    use DateFormatTrait;

    protected $fillable = ['name', 'comment', 'locale', 'position_id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_posts');
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public static function createNotExists($attributes, $positionId)
    {
        $attributes = $attributes instanceof Collection ? $attributes->toArray() : $attributes;

        if (is_array($attributes)) {
            $allPosts = self::all();
            $posts = collect($allPosts)->mapWithKeys(function ($item, $key) {
                return [$item['name'] => $key];
            })->toArray();
            foreach ($attributes as $attribute) {
                $attribute['locale'] = !empty($attribute['locale']) ? json_encode($attribute['locale']) : null;
                if (!isset($posts[$attribute['name']])) {
                    $data = self::filterAttributes($attribute);
                    $data['position_id'] = $positionId;
                    static::create($data);
                }
            }
        }
    }

    public static function filterAttributes(array $attributes)
    {
        $columns = ['number', 'name', 'comment', 'locale'];
        $data = [];
        foreach ($attributes as $key => $item) {
            if (in_array($key, $columns)) {
                $data[$key] = $item;
            }
        }
        return $data;
    }
}
