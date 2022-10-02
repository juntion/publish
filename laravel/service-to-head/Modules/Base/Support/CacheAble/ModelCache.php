<?php

namespace Modules\Base\Support\CacheAble;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Collection;

trait ModelCache
{
    protected static $modelCacheKey;

    public static function bootModelCache()
    {
        $redis = Redis::connection('cache');

        static::updating(function ($model) use ($redis) {
            if ($redis->hexists(static::getModelCacheKey(), $model->getKey())) {
                return (bool)$redis->hdel(static::getModelCacheKey(), $model->getKey());
            }
        });
        static::deleting(function ($model) use ($redis) {
            if ($redis->hexists(static::getModelCacheKey(), $model->getKey())) {
                return (bool)$redis->hdel(static::getModelCacheKey(), $model->getKey());
            }
        });
    }

    /**
     * 如果使用缓存，则不能指定具体的数据表字段
     */
    public static function findFromCache($id)
    {
        $redis = Redis::connection('cache');

        if (is_array($id) || $id instanceof Arrayable) {
            return static::findManyFromCache($id);
        }

        if (!$redis->hexists(static::getModelCacheKey(), $id)) {
            $model = static::find($id);
            $redis->hset(static::getModelCacheKey(), $id, serialize($model));
            return $model;
        }

        return unserialize($redis->hget(static::getModelCacheKey(), $id));
    }

    public static function findManyFromCache($ids)
    {
        $ids = $ids instanceof Arrayable ? $ids->toArray() : $ids;

        $collection = new Collection();
        foreach ($ids as $id) {
            $collection->push(static::findFromCache($id));
        }

        return $collection;
    }

    public static function getModelCacheKey()
    {
        return static::$modelCacheKey ?? (static::$modelCacheKey = static::class . ':cache');
    }
}
