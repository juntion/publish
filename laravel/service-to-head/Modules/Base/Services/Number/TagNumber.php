<?php

namespace Modules\Base\Services\Number;

use Illuminate\Support\Facades\Redis;

/**
 * 生成标签编号
 */
class TagNumber extends Number
{
    public function prefix(): string
    {
        return '';
    }

    /**
     * @return int|mixed|string
     */
    public function get()
    {
        if (empty(Redis::HGET($this->getKey(), 'increment'))) {
            $number = 1001;
            Redis::HSET($this->getKey(), 'increment', $number);
            return $number;
        }

        $increment = Redis::HINCRBY($this->getKey(), 'increment', 1);

        return $this->prefix() . $increment;
    }

    /**
     * @param $number
     */
    public function set($number)
    {
        Redis::HSET($this->getKey(), 'increment', $number);
    }
}
