<?php

namespace Modules\Base\Support;


use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Modules\Base\Entities\Base\OpenAuth;

class Signature
{
    private static $param = [];
    
    public static function get()
    {
        return self::randStr();
    }
    
    public static function randStr($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    /**
     * token验证
     *
     * @param Request $request
     * @return bool
     */
    public static function verify(Request $request)
    {
        if (self::checkParam($request)) {
            $res = OpenAuth::query()->whereKey(self::$param['key_id'])->where('status', 0)->first();
            $exp = $res->exp_time;
            $accessKeySecret = $res->access_key_secret;
            if ($res && $accessKeySecret) {
                // 检查授权过期时间
                if ($exp && time() > $exp) return false;
                // 检查请求时间是否合法。与服务器时间差在60s内
                if (abs(self::$param['timestamp'] - time()) > 60) return false;
                // 对称加密检查
                $original = [
                    'k' => self::$param['key_id'],    // access key id(授权ID);
                    'r' => self::$param['random'],    // 自定义随机数
                    't' => self::$param['timestamp'], // 请求时间戳(单位秒)
                    'f' => 'fs',                      // fs(固定值)
                ];
                $originalStr = http_build_query($original);
                // 加密规则：使用sha1算法，加密k,r,t,f内容$originalStr，密钥为分配的密钥，将加密后的16进制编码拼接$originalStr后再base64，即为auth token
                $signStr = base64_encode(hash_hmac('sha1', $originalStr, $accessKeySecret) . $originalStr);
                if (self::$param['token'] == $signStr) {
                    return true;
                }
            }
        }
        return false;
    }
    
    public static function checkParam(Request $request)
    {
        $key = $request->header('authorization');
        $originStr = strstr(base64_decode($key), 'k');
        $arr = explode('&', $originStr);
        self::$param = [];
        if (sizeof($arr)) {
            foreach ($arr as $v) {
                $d = explode('=', $v);
                if ($d[0] == 'k' && $d[1]) {
                    self::$param['key_id'] = $d[1];
                }
                if ($d[0] == 'r' && $d[1]) {
                    self::$param['random'] = $d[1];
                }
                if ($d[0] == 't' && $d[1]) {
                    self::$param['timestamp'] = $d[1];
                }
            }
            self::$param['token'] = $key;
        }
        return Arr::has(self::$param, ['key_id', 'token', 'random', 'timestamp']);
    }
}