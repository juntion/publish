<?php

namespace App\Services\Common\Redis;

use App\Services\Common\SetDataBase;

class RedisService
{
    /**
     * 读取 redis 缓存
     * @param $key string|integer 键名
     * @param $prefix string 前缀
     * @return string/bool
     */
    public static function getRedisKeyValue($key, $prefix = '')
    {
        $redis = self::getRedis();
        if (!$redis::$is_connect) {
            return false;
        }
        if (!is_string($key) && !is_numeric($key)) {
            return false;
        }

        $key = $prefix . ':' . md5($key);
        $result = $redis->get($key);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 设置 redis 缓存
     * 存储类型：string
     * @param $key string|integer 键名
     * @param $value string 键值
     * @param $time int 生存时间(秒)，0为永不过期
     * @param $prefix string 前缀(区分缓存类型)
     * @return string/bool
     */
    public static function setRedisKeyValue($key, $value, $time = 0, $prefix = '')
    {
        $redis = self::getRedis();
        if (!$redis::$is_connect) {
            return false;
        }
        if (!is_string($key) && !is_numeric($key)) {
            return false;
        }
        $key = md5($key);
        $key = $prefix . ':' . $key;
        $result = $redis->set($key, $value, $time);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 清理 redis 某一前缀的所有缓存
     * @param  $prefix string 前缀名
     * @return int
     */
    public static function removeRedisByPrefix($prefix)
    {
        $redis = self::getRedis();
        if (!$redis::$is_connect) {
            return false;
        }
        if (empty($prefix)) {
            return false;
        }
        $keysArr = $redis->keys($prefix . '*');
        if (count($keysArr)) {
            return $redis->delete($keysArr);
        } else {
            return 0;
        }
    }

    /**
     * 清理 redis 某个前缀，某个key的缓存
     * fairy 2019.2.16 add
     * @param $key string 键名
     * @param  $prefix string 前缀名
     * @return int
     */
    public static function removeRedisByKey($key, $prefix)
    {
        $redis = self::getRedis();
        if (!$redis::$is_connect) {
            return false;
        }
        if (empty($key) || empty($prefix)) {
            return false;
        }
        $key = md5($key);
        $key = $prefix . ':' . $key;
        $keysArr = $redis->keys($key);
        if (count($keysArr)) {
            return $redis->delete($keysArr);
        } else {
            return 0;
        }
    }

    /**
     * 键值+1
     * @param  $key string|integer 键名
     * @param  $prefix string 前缀名
     * @return int|bool
     */
    public static function incrRedisByKey($key, $prefix)
    {
        $redis = self::getRedis();
        if (!$redis::$is_connect) {
            return false;
        }
        if (!is_string($key) && !is_numeric($key)) {
            return false;
        }
        $key = md5($key);
        $key = $prefix . ':' . $key;
        $result = $redis->incr($key);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 键值-1
     * @param  $key string|integer 键名
     * @param  $prefix string 前缀名
     * @return int|bool
     */
    public static function decrRedisByKey($key, $prefix)
    {
        $redis = self::getRedis();
        if (!$redis::$is_connect) {
            return false;
        }
        if (!is_string($key) && !is_numeric($key)) {
            return false;
        }
        $key = md5($key);
        $key = $prefix . ':' . $key;
        $result = $redis->decr($key);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public static function flushAllDb()
    {
        $redis = self::getRedis();
        if (!$redis::$is_connect) {
            return false;
        }
        $redis::flushAll();
    }

    public static function flushCurrentDb($db = 0)
    {
        $redis = self::getRedis();
        if (!$redis::$is_connect) {
            return false;
        }
        $redis::flushdb($db);
    }

    /**
     * add by rebirth  2019/07/20
     * redis 切库
     *
     * @param int $db
     * @return bool
     */
    public static function selectRedisDB($db = 0)
    {
        $redis = self::getRedis();
        if (!$redis::$is_connect) {
            return false;
        }
        return $redis::select((int)$db);
    }

    /**
     * add by rebirth  2019/07/20
     * 模仿上面的流程用key删除一个值，但是取消了$prefix的限制
     *
     * @param string $key
     * @return bool
     */
    public static function delOneValueFromRedisByKey($key)
    {
        $redis = self::getRedis();
        if (!$redis::$is_connect) {
            return false;
        }
        if (!is_string($key) && !is_numeric($key)) {
            return false;
        }
        $key = md5($key);
        $key = ':' . $key;
        $keysArr = $redis->keys($key);
        if (count($keysArr)) {
            return $redis->delete($keysArr);
        } else {
            return 0;
        }
    }

    /**
     * add by rebirth  2019/08/15
     * 将key的值设为value,当且仅当key不存在的时候,成功返回1,不成功返回0
     *
     * @param string $key
     * @return bool
     */
    public static function setnxRedisKeyValue($key, $value)
    {
        $redis = self::getRedis();
        if (!$redis::$is_connect) {
            return false;
        }
        if (!is_string($key) && !is_numeric($key)) {
            return false;
        }
        return $redis->setnx($key, $value);
    }

    /**
     * add by rebirth  2019/08/15
     * 删除与1个值，取消了key的md5加密
     *
     * @param string $key
     * @return bool
     */
    public static function delRedisByKey($key)
    {
        $redis = self::getRedis();
        if (!$redis::$is_connect) {
            return false;
        }
        if (!is_string($key) && !is_numeric($key)) {
            return false;
        }
        return $redis->delete($key);
    }

    /**
     * by rebirth   2019/10/08
     * 设置redis的key的过期时间
     *
     * @param $key
     * @param $time
     * @return bool
     */
    public static function setRedisKeyExpire($key, $time)
    {
        $redis = self::getRedis();
        if (!$redis::$is_connect) {
            return false;
        }
        if (!is_string($key) && !is_numeric($key)) {
            return false;
        }

        return $redis->expire($key, $time);
    }

    /*
     * add by rebirth 2019-07-24
     * 获取redis实例
     */
    public static function getRedis()
    {
        global $redis;
        if (!is_object($redis) || !($redis instanceof RedisReload)) {
            $redis = SetDataBase::setRedis();
        }
        return $redis;
    }
}
