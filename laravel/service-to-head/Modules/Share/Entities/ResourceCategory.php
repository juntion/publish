<?php


namespace Modules\Share\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Redis;
use Modules\Base\Entities\Model;
use Modules\Base\Support\CacheAble\ModelCache;
use Modules\Base\Support\Search\Searchable;
use Modules\Share\Database\Factories\CategoriesFactory;
use Modules\Share\Entities\Traits\CategoryCacheTrait;
use Modules\Share\Entities\Traits\CategoryTrait;

class ResourceCategory extends Model
{
    use CategoryTrait, SoftDeletes, Searchable, ModelCache, CategoryCacheTrait;

    protected $table = 'share_resource_categories';

    protected $fillable = [
        'uuid', 'parent_uuid', 'name', 'type', 'background' , 'sort', 'sum', 'one_level_uuid', 'two_level_uuid', 'three_level_uuid'
    ];

    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'share_resources_to_categories', 'category_uuid', 'resource_uuid');
    }

    protected static function newFactory()
    {
        return CategoriesFactory::new();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|mixed
     */
    public static function findFromCache($id)
    {
        $redis = Redis::connection('cache');

        if (!$redis->hexists(static::getModelCacheKey(), $id)) {
            $model = static::query()->withTrashed()->find($id);
            $redis->hset(static::getModelCacheKey(), $id, serialize($model));
            return $model;
        }

        return unserialize($redis->hget(static::getModelCacheKey(), $id));
    }
}
