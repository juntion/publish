<?php
/**
 * Created by PhpStorm.
 * User: King
 * Date: 2020/6/12
 * Time: 10:46
 */

namespace App\Support;

use GatewayWorker\Lib\Gateway;

/**
 * Class WsGateway
 * @package App\Support
 * @author: King
// * @method static void  sendToAll($message, $client_id_array = null, $exclude_client_id = null, $raw = false)
// * @method static void  sendToClient($client_id, $message)
 * @method static int   isUidOnline($uid)
 * @method static int   isOnline($client_id)
 * @method static array getAllClientInfo($group = '')
 * @method static array getAllClientSessions($group = '')
 * @method static array getClientInfoByGroup($group)
 * @method static array getClientSessionsByGroup($group)
 * @method static int   getAllClientIdCount()
 * @method static int   getAllClientCount()
 * @method static int   getClientIdCountByGroup($group = '')
 * @method static int   getClientCountByGroup($group = '')
 * @method static array getClientIdListByGroup($group)
 * @method static array getAllClientIdList()
 * @method static array getClientIdByUid($uid)
 * @method static array getUidListByGroup($group)
 * @method static int   getUidCountByGroup($group)
 * @method static array getAllUidList()
 * @method static int   getAllUidCount()
 * @method static mixed getUidByClientId($client_id)
 * @method static array getAllGroupIdList()
 * @method static array getAllGroupUidCount()
 * @method static array getAllGroupUidList()
 * @method static array getAllGroupClientIdList()
 * @method static array getAllGroupClientIdCount()
// * @method static void  closeClient($client_id, $message = null)
 * @method static bool  destoryClient($client_id)
 * @method static bool  destoryCurrentClient()
 * @method static void  bindUid($client_id, $uid)
 * @method static void  unbindUid($client_id, $uid)
 * @method static void  joinGroup($client_id, $group)
 * @method static void  leaveGroup($client_id, $group)
 * @method static void  ungroup($group)
// * @method static void  sendToUid($uid, $message)
// * @method static void  sendToGroup($group, $message, $exclude_client_id = null, $raw = false)
 * @method static bool  setSocketSession($client_id, $session_str)
 * @method static void  setSession($client_id, array $session)
 * @method static void  updateSession($client_id, array $session)
 * @method static mixed getSession($client_id)
 * @method static setBusinessWorker($business_worker_instance)
 */
class WsGateway
{
    /**
     * @param $data
     * @return string
     * @author: King
     * @version: 2020/6/12 12:30
     */
    protected static function format($data)
    {
        if (is_array($data)) {
            return json_encode($data);
        }

        return $data;
    }

    public static function isEnabled()
    {
        return config('gateway-worker.default_register_address') ? true : false;
    }

    /**
     * 向所有客户端连接(或者 client_id_array 指定的客户端连接)广播消息
     *
     * @param mixed $message           向客户端发送的消息
     * @param array  $client_id_array   客户端 id 数组
     * @param array  $exclude_client_id 不给这些client_id发
     * @param bool   $raw               是否发送原始数据（即不调用gateway的协议的encode方法）
     * @return void
     * @throws \Exception
     */
    public static function sendToAll($message, $client_id_array = null, $exclude_client_id = null, $raw = false)
    {
        if (self::isEnabled()) Gateway::sendToAll(self::format($message), $client_id_array, $exclude_client_id, $raw);
    }

    /**
     * 向某个client_id对应的连接发消息
     *
     * @param int    $client_id
     * @param mixed $message
     * @return void
     */
    public static function sendToClient($client_id, $message)
    {
        if (self::isEnabled()) Gateway::sendToClient($client_id, self::format($message));
    }

    /**
     * 踢掉某个客户端，并以$message通知被踢掉客户端
     *
     * @param string $client_id
     * @param mixed $message
     * @return void
     */
    public static function closeClient($client_id, $message = null)
    {
        if (self::isEnabled()) Gateway::closeClient($client_id, self::format($message));
    }

    /**
     * 向所有 uid 发送
     *
     * @param int|string|array $uid
     * @param mixed           $message
     *
     * @return void
     */
    public static function sendToUid($uid, $message)
    {
        if (self::isEnabled()) Gateway::sendToUid($uid, self::format($message));
    }

    /**
     * 向 group 发送
     *
     * @param int|string|array $group             组（不允许是 0 '0' false null array()等为空的值）
     * @param mixed           $message           消息
     * @param array            $exclude_client_id 不给这些client_id发
     * @param bool             $raw               发送原始数据（即不调用gateway的协议的encode方法）
     *
     * @return void
     */
    public static function sendToGroup($group, $message, $exclude_client_id = null, $raw = false)
    {
        if (self::isEnabled()) Gateway::sendToGroup($group, self::format($message), $exclude_client_id, $raw);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @author: King
     * @version: 2020/7/2 14:22
     */
    public static function __callStatic($name, $arguments)
    {
        if (self::isEnabled()) {
            return Gateway::$name(...$arguments);
        } else {
            return false;
        }
    }
}