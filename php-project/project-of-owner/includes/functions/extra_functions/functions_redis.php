<?php

use App\Services\Common\Redis\RedisReload;
use App\Services\Common\SetDataBase;

/**
 * Created by Array.
 * Date: 2017/12/27
 * Time: 18:26
 * 存放所有调用 Redis 的函数
 */

/**
 * 读取 redis 缓存
 * @param $key string|integer 键名
 * @param $prefix string 前缀
 * @return string/bool
 */
function get_redis_key_value($key, $prefix = '')
{
    $redis = getRedis();
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
 * @param $value // 键值
 * @param $time int 生存时间(秒)，0为永不过期
 * @param $prefix string 前缀(区分缓存类型)
 * @return string/bool
 */
function set_redis_key_value($key, $value, $time = 0, $prefix = '')
{
    $redis = getRedis();
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
function remove_redis_by_prefix($prefix)
{
    $redis = getRedis();
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
function remove_redis_by_key($key, $prefix)
{
    $redis = getRedis();
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
function incr_redis_by_key($key, $prefix)
{
    $redis = getRedis();
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
function decr_redis_by_key($key, $prefix)
{
    $redis = getRedis();
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

function flushAllDb()
{
    $redis = getRedis();
    if (!$redis::$is_connect) {
        return false;
    }
    $redis::flushAll();
}

function flushCurrentDb($db = 0)
{
    $redis = getRedis();
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
function selectRedisDB($db = 0)
{
    $redis = getRedis();
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
function delOneValueFromRedisByKey($key)
{
    $redis = getRedis();
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
function setnx_redis_key_value($key, $value)
{
    $redis = getRedis();
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
function del_redis_by_key($key)
{
    $redis = getRedis();
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
function set_redis_key_expire($key, $time)
{
    $redis = getRedis();
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
function getRedis()
{
    global $redis;
    if (!is_object($redis) || !($redis instanceof RedisReload)) {
        $redis = SetDataBase::setRedis();
    }
    return $redis;
}
