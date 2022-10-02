<?php


namespace Modules\Base\Services\Number;

use Illuminate\Support\Facades\Redis;
use Modules\Base\Contracts\Number\Number as ContractsNumber;

abstract class Number implements ContractsNumber
{

    /**
     * 两位前缀 + 年月日 + 流水号 + 两位随机数 例如：CW 20200101 0001 58
     * @return mixed|string
     */
    public function get()
    {
        $time = date("Ymd");      //编号日期

        if (Redis::HGET($this->getKey(), 'time') != $time) {
            Redis::HSET($this->getKey(), 'time', $time);
            Redis::HSET($this->getKey(), 'increment', 0);
        }

        $increment = Redis::HINCRBY($this->getKey(), 'increment', 1);         //编号 流水号
        $fill = strlen($increment) < 4 ? str_repeat('0', 4 - strlen($increment)) : '';  //编号 0 填充

        return $this->prefix() . $time . $fill . $increment . mt_rand(0, 9) . mt_rand(0, 9);
    }

    public function getKey()
    {
        return static::class . ':number';
    }

    abstract public function prefix();
}
