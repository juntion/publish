<?php

namespace App\Services\Common\Redis;

use Predis\Client;

/**
 *
 * 对 RedisPackage.class.php 重写并去除php_redis
 * Class ReloadRedis
 * @package App\Services\Common\Redis
 */
class RedisReload
{
    private static $handler = null;
    private static $instance = null;
    public static $is_connect = true;

    private function __construct($config = [])
    {
        $options = [
            'host'     => $config['host'],
            'port'     => $config['port'],
            'database' => $config['select']
        ];
        $other = [
            'prefix' => $config['prefix']
        ];
        try {
            self::$handler = new Client($options, $other);
            self::$handler->connect();
            if (!self::$handler->isConnected()) {
                self::$is_connect = false;
            } else {
                if (0 != $config['select']) {
                    self::$handler->select($config['select']);
                }
            }
        } catch (\Exception $e) {
            self::$is_connect = false;
        };
    }


    /**
     * @param $config
     * @return RedisReload
     */
    public static function getInstance($config)
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    /**
     * 禁止外部克隆
     */
    public function __clone()
    {
        trigger_error('Clone is not allow!', E_USER_ERROR);
    }

    /**
     * 写入缓存
     * @param string $key 键名
     * @param string $value 键值
     * @param int $exprie 过期时间 0:永不过期
     * @return bool
     */
    public static function set($key, $value, $exprie = 0)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            if (is_object($value) || is_array($value)) {
                $value = serialize($value);
            }
            if ($exprie == 0) {
                $set = self::$handler->set($key, $value);
            } else {
                $set = self::$handler->setex($key, $exprie, $value);
            }
            return $set;
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 将key的值设为value,当且仅当key不存在的时候,成功返回1,不成功返回0
     * @param string $key 键名
     * @param string $value 键值
     * @return bool
     */
    public static function setnx($key, $value)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            if (is_object($value) || is_array($value)) {
                $value = serialize($value);
            }
            return self::$handler->setnx($key, $value);
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 读取缓存
     * @param string $key 键值
     * @return mixed
     */
    public static function get($key)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            $value = self::$handler->get($key);
            $value_serl = @unserialize($value);
            if (is_object($value_serl) || is_array($value_serl)) {
                return $value_serl;
            }
            return $value;
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 批量删除缓存
     * @param array/string $key 键名
     * @return mixed
     */
    public static function delete($key)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            return self::$handler->del($key);
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 获取值长度
     * @param string $key
     * @return int
     */
    public static function lLen($key)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            return self::$handler->lLen($key);
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 将一个或多个值插入到列表头部
     * @param $key
     * @param $value
     * @return int
     */
    public static function LPush($key, $value)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            return self::$handler->lPush($key, $value);
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 移出并获取列表的第一个元素
     * @param string $key
     * @return string
     */
    public static function lPop($key)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            return self::$handler->lPop($key);
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 清空整个 Redis 服务器的数据(删除所有数据库的所有 key )，慎重使用！
     * @return boolean
     */
    public static function flushAll()
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            //return self::$handler->flushAll();
            return false;
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 查询键名是否存在
     * @param string $key
     * @return array
     */
    public static function keys($key)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            return self::$handler->keys($key);
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /*
     *
     * 键值+1
     * @param string $key
     * */
    public static function incr($key)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            return self::$handler->incr($key);
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /*
     * 键值+1
     * @param string $key
     * */
    public static function decr($key)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            return self::$handler->decr($key);
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 为有序列表添加元素
     * @param $key string
     * @param $score int
     * @param $value string
     * @return int
     */
    public static function zAdd($key, $score, $value)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            return self::$handler->zAdd($key, $score, $value);
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 取出有序列表元素
     * @param $key string
     * @param $start int
     * @param $end int
     * @param $withscore string
     * @return array
     */
    public static function zRange($key, $start, $end, $withscore = null)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            return self::$handler->zRange($key, $start, $end, $withscore);
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 查询有序列表某元素排名
     * @param $key string $key
     * @param $value string $key
     * @return int
     */
    public static function zRank($key, $value)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            return self::$handler->zRank($key, $value);
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 删除有序列表元素
     * @param $key string $key
     * @param $value string $key
     * @return int
     */
    public static function zRem($key, $value)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            return self::$handler->zRem($key, $value);
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 判断redis是否可用
     * @return string
     */
    public static function ping()
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            return self::$handler->ping();
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 判断key是否存在
     * @param $key
     * @return bool
     */
    public static function exists($key)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            return self::$handler->exists($key);
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 设置key过期时间
     */
    public static function expire($key, $time)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            return self::$handler->expire($key, $time);
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 查看redis key过期时间
     */
    public static function ttl($key)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            return self::$handler->ttl($key);
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 选择库
     * @param int $db
     * @return bool
     */
    public static function select($db = 0)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            return self::$handler->select($db);
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 删除指定库
     * @param int $db
     * @return bool
     */
    public static function flushdb($db = 0)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            return self::$handler->flushdb($db);
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 销毁对象
     */
    public function __destruct()
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            // TODO: Implement __destruct() method.
            self::$handler->disconnect();
        } catch (\Exception $exception) {
            self::$is_connect = false;
        }
    }

    /**
     * 设置集合
     *
     * @param $member
     * @param $value
     * @return bool
     */
    public static function sAdd($member, $value)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            $return = self::$handler->sAdd($member, $value);
            return $return;
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 删除集合中的指定元素
     *
     * @param $key
     * @param $member
     * @return bool
     */
    public static function sRem($key, $member)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            $return = self::$handler->srem($key, $member);
            return $return;
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 判断member是否是集合key中的元素
     *
     * @param $key
     * @param $member
     * @return int or bool
     */
    public static function sIsMember($key, $member)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            $return = self::$handler->sismember($key, $member);
            return $return;
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 返回无序集合所有元素的个数
     *
     * @param $key
     * @return int or bool
     */
    public static function sCard($key)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            $return = self::$handler->scard($key);
            return $return;
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 获取list 集合数据
     *
     * @param string $key
     * @param int $start
     * @param int $end
     * @return array|bool|void
     */
    public static function lGetRange($key = "", $start = 0, $end = -1)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            return self::$handler->lRange($key, $start, $end);
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 移除并获取list的最后一个元素
     * @param string $key 键名
     * @return mixed
     */
    public static function rPop($key)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            $value = self::$handler->rpop($key);
            $value_serl = @unserialize($value);
            if (is_object($value_serl) || is_array($value_serl)) {
                return $value_serl;
            }
            return $value;
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }

    /**
     * 移除list中的指定元素
     * @param string $key 键名
     * @param string $value 键值
     * @param int $count 长度
     * @return mixed
     */
    public static function lRem($key, $value, $count = 0)
    {
        try {
            if (!self::$is_connect) {
                return false;
            }
            $value = self::$handler->lrem($key, $count, $value);
            $value_serl = @unserialize($value);
            if (is_object($value_serl) || is_array($value_serl)) {
                return $value_serl;
            }
            return $value;
        } catch (\Exception $exception) {
            self::$is_connect = false;
            return false;
        }
    }
}
