<?php

namespace Modules\Tag\Entities;

use Illuminate\Support\Facades\Storage;
use Modules\Base\Contracts\Number\Factory;
use Modules\Base\Entities\Model;
use Illuminate\Support\Str;
use Modules\Base\Support\Search\Searchable;
use Modules\Tag\Database\Factories\TagDataFactory;
use Modules\Tag\Observers\TagDataObserver;

class TagData extends Model
{
    use TagOperationLogTrait, Searchable;

    protected $fillable = ['uuid', 'number', 'name', 'parent_uuid', 'path', 'level', 'status', 'locale', 'type', 'url_name', 'avatar',];

    protected $casts = [
        'locale' => 'json',
    ];

    // 记录属性变化
    public const LOG_ATTRIBUTES = ['name', 'parent_uuid', 'level', 'status', 'locale', 'type', 'url_name',];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Str::uuid()->getHex()->toString();
            // 注意：如果指定了number，务必要维护redis(TagNumber->set())中的最大值，否则会发生冲突
            $model->number = $model->number ?? self::tagNumber();
            $model->url_name = $model->url_name ?? self::urlSlug($model->name);
            [$path, $level] = self::newPathAndLevel($model->parent_uuid);
            $model->path = $path;
            $model->level = $level;
        });
    }

    protected static function booted()
    {
        parent::booted();

        TagData::observe(TagDataObserver::class);
    }

    // 标签编号
    protected static function tagNumber()
    {
        $tagNumber = app()->make(Factory::class)->create('TAG');
        return $tagNumber->get();
    }

    // 标签 path level
    public static function newPathAndLevel($parentUuid)
    {
        $path = '-';
        $level = 1;
        if ($parentUuid) {
            $parent = static::query()->where('uuid', $parentUuid)->first();
            $path = $parent->path . $parent->uuid . '-';
            $level = $parent->level + 1;
        }
        return [$path, $level];
    }

    public function parent()
    {
        return $this->belongsTo(TagData::class, 'parent_uuid');
    }

    /**
     * @return array
     */
    public function getParentIdsAttribute()
    {
        return array_filter(explode('-', trim($this->path, '-')));
    }

    public function getChildrenAttribute()
    {
        return TagData::query()->where('parent_uuid', $this->uuid)->get();
    }

    public function operationLogs()
    {
        return $this->hasMany(TagOperationLog::class, 'tag_data_uuid', 'uuid');
    }

    public function tagDataSource()
    {
        return $this->hasMany(TagDataSource::class, 'tag_data_uuid', 'uuid');
    }

    public function getLocaleArrAttribute()
    {
        if (empty($this->locale)) {
            return [];
        }
        $res = [];
        foreach ($this->locale as $lang => $name) {
            $res[] = [
                'lang' => $lang,
                'name' => $name,
            ];
        }
        return $res;
    }

    public function toSearchableArray()
    {
        $arr = $this->toArray();
        $arr['number'] = (string)$arr['number'];
        return $arr;
    }

    protected static function newFactory()
    {
        return TagDataFactory::new();
    }

    // 原 community 中url_name 生成规则
    public static function urlSlug($name, $separator = '-')
    {
        $name = str_replace('&', ' and ', $name);
        $name = str_replace('/', '-', $name);
        $name = preg_replace('/[`~!@#$%^&*()_+=;\':"{}[\]?<,.>]/', '-', $name);

        // Convert all dashes/underscores into separator
        $flip = $separator === '-' ? '_' : '-';

        $name = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $name);

        // Replace @ with the word 'at'
        $name = str_replace('@', $separator . 'at' . $separator, $name);

        // Remove all characters that are not the separator, letters, numbers, or whitespace.
        $name = preg_replace('![^' . preg_quote($separator) . '\pL\pN\s]+!u', '', strtolower($name));

        // Replace all separator characters and whitespace by a single separator
        $name = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $name);

        return trim($name, $separator);
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? config('app.url') . Storage::url($this->avatar) : '';
    }
}
