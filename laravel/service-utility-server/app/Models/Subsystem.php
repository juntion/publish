<?php

namespace App\Models;

use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Subsystem extends Model
{
    use DateFormatTrait;

    protected $fillable = ['name', 'locale', 'sidebar', 'homepage'];

    public function forbidUsers()
    {
        return $this->belongsToMany(User::class, 'forbidden_logins')->withTimestamps();
    }

    // 如果不存在此子系统则创建
    public static function createNotExists($attributes)
    {
        $attributes = $attributes instanceof Collection ? $attributes->toArray() : $attributes;

        if (is_array($attributes)) {
            $allSubsystems = self::all();
            $subsystems = collect($allSubsystems)->mapWithKeys(function ($item, $key) {
                return [$item['name'] . $item['guard_name'] => $key];
            })->toArray();
            foreach ($attributes as $attribute) {
                $attribute['locale'] = !empty($attribute['locale']) ? json_encode($attribute['locale']) : null;
                if (!isset($subsystems[$attribute['name'] . $attribute['guard_name']])) {
                    $data = self::filterAttributes($attribute);
                    static::create($data);
                }
            }
        }
    }

    public static function filterAttributes(array $attributes)
    {
        $columns = ['name', 'link', 'guard_name', 'locale'];
        $data = [];
        foreach ($attributes as $key => $item) {
            if (in_array($key, $columns)) {
                $data[$key] = $item;
            }
        }
        return $data;
    }
}
