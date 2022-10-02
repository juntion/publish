<?php

namespace Modules\Base\Contracts\CacheAble;

use Illuminate\Support\Facades\Redis;

abstract class Cache
{
    private $redis;
    protected $key;

    public function __construct()
    {
        $this->redis = Redis::connection('cache');
    }

    public function getKey()
    {
        return $this->key ?? $this->key = static::class . ':cache';
    }

    public function exists($field): bool
    {
        return (bool)$this->redis->hexists($this->getKey(), $field);
    }

    public function get($field)
    {
        return unserialize($this->redis->hget($this->getKey(), $field));
    }

    public function put($field, $value): bool
    {
        $this->redis->hset($this->getKey(), $field, serialize($value));

        return true;
    }

    public function forget($field): bool
    {
        if ($this->exists($field)) {
            return (bool)$this->redis->hdel($this->getKey(), $field);
        }
        return true;
    }

    public function flush(): bool
    {
        $this->redis->del($this->getKey());

        return true;
    }

    /**
     *  保存变量到 redis
     * @param $field
     * @param $value
     * @return bool
     */
    public function save($field, $value)
    {
        return $this->put($field, $this->dataBuild($value));
    }

    /**
     * 将原始数据转换成，redis存储的数据
     * @param $value
     * @return mixed
     */
    abstract protected function dataBuild($value);

    /**
     * 获取缓存数据，获取的数据为程序期望得到的数据，不是redis存的数据
     * @param $field
     * @return mixed
     */
    public function find($field)
    {
        if ($this->exists($field)) {
            $value = $this->get($field);
            return $this->dataResolve($value);
        }
    }

    /**
     * 对缓存数据的解析，解析出最终要的数据
     * @param $value
     * @return mixed
     */
    abstract protected function dataResolve($value);

    /**
     * 查询或者创建一个缓存
     *
     * @param $field
     * @param  callable  $callback
     * @return mixed
     */
    public function findOrSaveCache($field, callable $callback)
    {
        if ($this->exists($field)) {
            return $this->find($field);
        } else {
            $cacheData = $callback($field);
            $this->save($field, $cacheData);
            return $this->find($field);
        }
    }
}
