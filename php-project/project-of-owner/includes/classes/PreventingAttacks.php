<?php
/**
 * Created by PhpStorm.
 * User: yaowei
 * Date: 2018/12/24
 * Time: 下午2:34
 */

class PreventingAttacks
{
    private static $limit = 50;
    private static $despireTime = 1;
    private static $prefix = "preventAttacks:";
    private static $redis = "";
    private static $lockTime = 900;

    public function __construct()
    {
        global $redis;
        self::$redis = $redis;
        $redis::select(10);
    }

    /**
     * 防止cc 攻击
     * status 200:允许访问  403:禁止服务器拒绝请求
     * @return array
     */
    public static function PreventingCCAttacks()
    {
        if(self::get_naps_bot() || self::get_astrict_ip()){
            return array("status" => 200);
        }
        $key = self::getKey();
        $lockKey =  self::getKey(self::$prefix . "webLock");
        $limit = self::$limit;
        $redis = self::$redis;
        $connect_status = $redis->ping();
        $despireTime = self::$despireTime;
        if ($connect_status === "+PONG") {
            $lockKey = $redis->exists($lockKey);
            if ($lockKey) {
                if($redis->exists($key)){
                    $redis->delete($key);
                }
                return array(
                    "status" => 403
                );
            }
            $check = $redis->exists($key);
            $lockKey = $redis->get(self::$prefix."webLock");
            if($lockKey){
                return array(
                    "status" => 403
                );
            }
            if ($check) {
                $redis->incr($key);
                $count = $redis->get($key);
                if ($count > $limit) {
                    if(!$redis->exists($lockKey)){
                        $redis->set($lockKey,1, self::$lockTime);
                    }
                    $redis->set($key,0,$despireTime);
                    self::createLog();
                    return array(
                        "status" => 403
                    );
                }
            } else {
                if($redis->exists($lockKey)){
                    $redis->delete($lockKey);
                }
                $redis->incr($key);
                $redis->expire($key, $despireTime);
            }
        }
        return array("status" => 200);
    }

    /**
     * 创建记录日志
     */
    private static function createLog()
    {
        $info = json_encode($_SERVER);
        $path = "debug/challengeCollapsarAttack";
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $key = self::getKey();
        $file_name = "ccAttack-" . date("Ymd") . "-" . $key . ".log";
        file_put_contents($path . "/" . $file_name, $info);
    }

    /**
     * 获取存储key值
     * @return string
     */
    public static function getKey($lockKey="")
    {
        $agent = $_SERVER['HTTP_USER_AGENT'] ? $_SERVER['HTTP_USER_AGENT'] : "";
        $ip = self::get_real_ip();
        if($lockKey){
            $ip.=$lockKey;
        }
//        $token = $_SESSION['securityToken'] ? $_SESSION['securityToken'] : "";
        $key = self::$prefix . md5($ip . $agent);
        return $key;
    }

    /**
     * 删除当前key
     */
    public static function deleteLimitKey()
    {
        $redis = self::$redis;
        $keysArr = $redis::keys(self::$prefix . '*');
        if (count($keysArr)) {
            $redis::delete($keysArr);
        }
    }

    /**
     * 获取客户ip
     * @return array|false|string
     */
    public static function get_real_ip()
    {
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $realip = getenv('HTTP_X_FORWARDED_FOR');
            } else if (getenv('HTTP_CLIENT_IP')) {
                $realip = getenv('HTTP_CLIENT_IP');
            } else {
                $realip = getenv('REMOTE_ADDR');
            }
        }
        return $realip;
    }

    /**
     * 各大搜索引擎不参与屏蔽机制
     * @return bool|string
     */
    private static function get_naps_bot()
    {
        $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
        //谷歌
        if (strpos($useragent, 'google') !== false) {
            return 'Googlebot';
        }
        //微软
        if (strpos($useragent, 'msnbot') !== false) {
            return 'MSNbot';
        }
        //雅虎
        if (strpos($useragent, 'slurp') !== false) {
            return 'Yahoobot';
        }
        //搜狗
        if (strpos($useragent, 'Sogou') !== false) {
            return 'Sogou';
        }
        //俄罗斯
        if (strpos($useragent, 'yandexbot') !== false) {
            return 'YandexBot';
        }
        //WWW搜索引擎
        if (strpos($useragent, 'lycos') !== false) {
            return 'Lycos';
        }
        //百度
        if (strpos($useragent, 'baiduspider') !== false) {
            return 'baiduspider';
        }

        //bing
        if (strpos($useragent, 'bingbot') !== false) {
            return 'bingbot';
        }

        //Naver 韩国第一门户网站
        if (strpos($useragent, 'naverbot') !== false) {
            return 'Naver';
        }

        //SeznamBot 捷克的一个门户网站和搜索引擎
        if (strpos($useragent, 'seznambot') !== false) {
            return 'SeznamBot';
        }
        //DuckDuckGo 强调保护搜索者的隐私
        if (strpos($useragent, 'duckduckBot') !== false) {
            return 'DuckDuckGo';
        }
        //谷歌广告
        if (strpos($useragent, 'google adSense') !== false) {
            return 'Google AdSense';
        }
        //Mail.RU_Bot 俄罗斯互联网巨头
        if (strpos($useragent, 'mail.ru_bot') !== false) {
            return 'Mail.RU_Bot';
        }
        //daum 韩国门户网
        if (strpos($useragent, 'daum') !== false) {
            return 'daum';
        }
        return false;
    }

    public static function get_astrict_ip(){
        $ip_arr = array(
            //D座2楼100M电信网IP
            '59.175.180.242',
            '59.175.180.243',
            '59.175.180.244',
            //D座6楼50M电信网IP
            '61.183.246.50',
            //A6电信网IP
            '59.173.240.134',
            //A9电信网IP
            '58.49.96.166',
            //仓库联通IP
            '113.57.130.74',
            //德国仓库IP
            '169.254.65.255',
            //德国宿舍IP
            '95.90.199.46',
            //西雅图仓库IP
            '50.232.153.174',
            '76.121.174.225',
            //C3
            '113.57.132.202',
            '220.249.72.130',
            '61.183.195.134'
        );
        $ip = self::get_real_ip();
        if (in_array($ip,$ip_arr)){
            return true;
        }
        return false;
    }
}