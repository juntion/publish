<?php
/**
 * functions/sessions.php
 * Session functions
 *
 * @package functions
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: sessions.php 16745 2010-06-17 12:02:17Z wilt $
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

/**
 * modify by rebirth  2019.07.05
 * 1.去掉dynamodb
 * 2.写:mysql和redis 均要写入,都连不上未作处理
 * 3.读: 根据设置优先读STORE_SESSIONS里的,读不到则读另外一个,都读不到则返回空并记录异常
 */
if (in_array(STORE_SESSIONS, ['db'])) {
    //失效时间
    if (defined('DIR_WS_ADMIN')) {
        if (!$SESS_LIFE = (SESSION_TIMEOUT_ADMIN + 900)) {
            $SESS_LIFE = (SESSION_TIMEOUT_ADMIN + 900);
        }
    } else {
        if (!$SESS_LIFE = get_cfg_var('session.gc_maxlifetime')) {
            $SESS_LIFE = 86400;
        }
    }

    function read_from_redis($key)
    {
        selectRedisDB(9);
        $res = base64_decode(get_redis_key_value(zen_db_input($key)));
        selectRedisDB(0);
        return $res;
    }

    function read_from_mysql($key)
    {
        global $db;
        $qid = "select value from " . TABLE_SESSIONS . " where sesskey = '" . zen_db_input($key) . "'and expiry > '" . time() . "'";
        $value = $db->Execute($qid);
        if (isset($value->fields['value']) && $value->fields['value']) {
            $res = base64_decode($value->fields['value']);
            return $res;
        } else {
            return "";
        }
    }

    function write_to_redis($key, $val, $expiry)
    {
        selectRedisDB(9);
        //重复写是有效的，不需要先删后写
        $res = set_redis_key_value(zen_db_input($key), zen_db_input($val), zen_db_input($expiry));
        selectRedisDB(0);
        return $res;
    }

    function write_to_mysql($key, $val, $expiry)
    {
        global $db;
        if (!is_object($db)) {
            //PHP 5.2.0 bug workaround ...
            $db = new queryFactory();
            $db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, USE_PCONNECT, false);
        }
        $qid = "select count(*) as total from " . TABLE_SESSIONS . " where sesskey = '" . zen_db_input($key) . "'";
        $total = $db->Execute($qid);
        if ($total->fields['total'] > 0) {
            $sql = "update " . TABLE_SESSIONS . " set expiry = '" . zen_db_input($expiry) . "', value = '" . zen_db_input($val) . "' where sesskey = '" . zen_db_input($key) . "'";
            $result = $db->Execute($sql);
        } else {
            $sql = "insert into " . TABLE_SESSIONS . " values ('" . zen_db_input($key) . "', '" . zen_db_input($expiry) . "', '" . zen_db_input($val) . "')";
            $result = $db->Execute($sql);

        }
        return (!empty($result) && !empty($result->resource));
    }

    function destroy_from_mysql($key)
    {
        global $db;
        $sql = "delete from " . TABLE_SESSIONS . " where sesskey = '" . zen_db_input($key) . "'";
        return $db->Execute($sql);
    }

    function destroy_from_redis($key)
    {
        selectRedisDB(9);
        $res = delOneValueFromRedisByKey(zen_db_input($key));
        selectRedisDB(0);
        return $res;
    }

    function _sess_open($save_path, $session_name)
    {
        return true;
    }

    function _sess_close()
    {
        return true;
    }

    function _sess_read($key)
    {
        $val = read_from_redis($key);
        if (empty($val)) {
            $val = read_from_mysql($key);
        }
        if (empty($val)) {
//            error_log(date('Y-m-d H:i:s') . "\n  ERROR: get empty \n KET: $key \n VAL: $val \n\n",
//                3, str_replace('cache', '', DIR_FS_SQL_CACHE) . 'debug/session.log');
            return ("");
        } else {
            return $val;
        }

    }

    function _sess_write($key, $val)
    {
        $val = base64_encode($val);
        global $SESS_LIFE;
        $expiry = time() + $SESS_LIFE;
        $res1 = write_to_redis($key, $val, $SESS_LIFE);
        $res = write_to_mysql($key, $val, $expiry);
        if (!$res1) {
            error_log(date('Y-m-d H:i:s') . "\n  ERROR: session写入失败".time()." \n KET: $key \n VAL: $val \n \n Redis: $res1 \n Mysql: $res \n\n",
                3, str_replace('cache', '', DIR_FS_SQL_CACHE) . 'debug/sessionWrite.log');
        }
        // 只有当写入mysql成功时才算写入成功
        return $res;
    }

    function _sess_destroy($key)
    {
        $res_mysql = destroy_from_mysql($key);
        $res_redis = destroy_from_redis($key);
        $res = ($res_mysql !== false && $res_redis !== false);
        return $res;
    }

    function _sess_gc($maxlifetime)
    {
        global $db;
        $sql = "delete from " . TABLE_SESSIONS . " where expiry < " . time();
        $db->Execute($sql);
        return true;
    }

    session_set_save_handler('_sess_open', '_sess_close', '_sess_read', '_sess_write', '_sess_destroy', '_sess_gc');
}elseif (STORE_SESSIONS == 'redis'){
    ini_set('session.save_handler', 'redis');
    ini_set('session.save_path', 'tcp://'.REDIS_HOST.":".REDIS_PORT."?prefix=zenid:&database=9");
}

function zen_session_start()
{
    @ini_set('session.gc_probability', 1);
    @ini_set('session.gc_divisor', 1000);
    //if (defined('DIR_WS_ADMIN')) {
    @ini_set('session.gc_maxlifetime', (SESSION_TIMEOUT_ADMIN < 900 ? (SESSION_TIMEOUT_ADMIN + 900) : SESSION_TIMEOUT_ADMIN));
    //}
    if (preg_replace('/[a-zA-Z0-9]/', '', session_id()) != '') {
        zen_session_id(md5(uniqid(rand(), true)));
    }
    $temp = session_start();
    if (!isset($_SESSION['securityToken'])) {
        $_SESSION['securityToken'] = md5(uniqid(rand(), true));
    }
    return $temp;
}

function zen_session_register($variable)
{
    die('This function has been deprecated. Please use Register Globals Off compatible code');
}

function zen_session_is_registered($variable)
{
    die('This function has been deprecated. Please use Register Globals Off compatible code');
}

function zen_session_unregister($variable)
{
    die('This function has been deprecated. Please use Register Globals Off compatible code');
}

function zen_session_id($sessid = '')
{
    if (!empty($sessid)) {
        $tempSessid = $sessid;
        if (preg_replace('/[a-zA-Z0-9]/', '', $tempSessid) != '') {
            $sessid = md5(uniqid(rand(), true));
        }
        return session_id($sessid);
    } else {
        return session_id();
    }
}

function zen_session_name($name = '')
{
    if (!empty($name)) {
        $tempName = $name;
        if (preg_replace('/[a-zA-Z0-9]/', '', $tempName) == '') return session_name($name);
        return FALSE;
    } else {
        return session_name();
    }
}

function zen_session_close()
{
    if (function_exists('session_close')) {
        return session_close();
    }
}

function zen_session_destroy()
{
    return session_destroy();
}

function zen_session_save_path($path = '')
{
    if (!empty($path)) {
        return session_save_path($path);
    } else {
        return session_save_path();
    }
}

function zen_session_recreate()
{
    global $http_domain, $https_domain, $current_domain;
    if ($http_domain == $https_domain) {
        $saveSession = $_SESSION;
        $oldSessID = session_id();
        session_regenerate_id();
        $newSessID = session_id();
        session_id($oldSessID);
        session_id($newSessID);
        if (STORE_SESSIONS == 'db') {
            session_set_save_handler('_sess_open', '_sess_close', '_sess_read', '_sess_write', '_sess_destroy', '_sess_gc');
        }
//      session_start();
        $_SESSION = $saveSession;
        if (IS_ADMIN_FLAG !== true) {
            whos_online_session_recreate($oldSessID, $newSessID);
        }
    } else {
        /*
          $saveSession = $_SESSION;
          $oldSessID = session_id();
          session_regenerate_id();
          $newSessID = session_id();
          session_id($oldSessID);
          session_destroy();
          session_id($newSessID);
          session_set_cookie_params(0, '/', (zen_not_null($http_domain) ? $http_domain : ''));
          session_id($newSessID);
          if (STORE_SESSIONS == 'db') {
            session_set_save_handler('_sess_open', '_sess_close', '_sess_read', '_sess_write', '_sess_destroy', '_sess_gc');
          }
          session_start();
          session_set_cookie_params(0, '/', (zen_not_null($current_domain) ? $current_domain : ''));
          session_start();
          $_SESSION = $saveSession;
          */
    }
}
