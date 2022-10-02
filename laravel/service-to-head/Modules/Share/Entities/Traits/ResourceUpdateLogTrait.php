<?php


namespace Modules\Share\Entities\Traits;


use Chelout\RelationshipEvents\Concerns\HasBelongsToManyEvents;
use Illuminate\Support\Facades\Auth;
use Modules\Share\Entities\ResourceCategory;
use Modules\Share\Entities\ResourceChangeCache;
use Modules\Share\Entities\ResourceTag;

trait ResourceUpdateLogTrait
{
    use HasBelongsToManyEvents;

    protected static function bootResourceUpdateLogTrait()
    {
        static::belongsToManySynced(function ($relate, $parent, $ids) {
            static::updateRelateRedis($relate, $parent, $ids);
        });

        static::belongsToManyToggled(function ($relate, $parent, $ids) {
            static::updateRelateRedis($relate, $parent, $ids);
        });

        static::updated(function ($model) {
            if ($model->isDirty('name')) {
                static::updateRelateRedis('resource', $model, $model->name);
            }
        });
    }

    protected static function updateRelateRedis($relate, $parent, $ids)
    {
        if ($relate == 'tags' || $relate == 'categories' || $relate == 'resource') {
            $adminUuid = Auth::id();
            $cache = new ResourceChangeCache();
            $key = 'resource_' . $parent->uuid . '_user_' . $adminUuid;
            $log = $cache->find($key);

            if ($relate == 'tags') {
                $log[$relate] = ResourceTag::query()->whereIn('uuid', $ids)->get()->pluck('name')->all();
                $cache->save($key, $log);
            } elseif ($relate == 'categories') {
                $new_cate = ResourceCategory::query()->find(request()->input('category_uuid'));
                $log[$relate] = static::getCateArray($new_cate);
                $cache->save($key, $log);
            } elseif ($relate == 'resource') {
                $log[$relate] = [
                    'name' => $ids
                ];
                $cache->save($key, $log);
            }
        }
    }

    protected static function getCateArray($cate)
    {
        $cateNameArr = [];
        $parent = $cate;
        $level = $parent->level;
        for ($i = $level; $i >= 1; $i--) {
            $parent = $i == $level ? $parent : $parent->parent;
            array_unshift($cateNameArr, $parent->name);
        }
        return $cateNameArr;
    }
}
