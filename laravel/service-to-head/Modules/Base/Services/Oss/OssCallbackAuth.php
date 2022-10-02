<?php

namespace Modules\Base\Services\Oss;


use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OssCallbackAuth
{
    /**
     * @param $object
     * @return string
     */
    public static function getToken($object)
    {
        $time = time();
        $content = 'u=oss;r=' . Str::random(10) . ';t=' . $time . ';o=' . $object;
        return Crypt::encryptString($content);
    }
    
    /**
     * oss回调验证
     *
     * @param $token
     * @param $object  object name
     * @return bool
     */
    public static function check($token, $object)
    {
        try {
            $decrypted = Crypt::decryptString($token);
            $arr = explode(';', $decrypted);
            if (sizeof($arr)) {
                foreach ($arr as $item) {
                    $split = explode('=', $item);
                    if ($split[0] == 't') {
                        $time = $split[1];
                    }
                    if ($split[0] == 'o') {
                        $tokenObj = $split[1];
                    }
                }
                if ($time && $tokenObj && $object == $tokenObj && static::checkTime($time, config('oss.token_timeout'))) {
                    return true;
                }
            }
            return false;
        } catch (DecryptException $e) {
            Log::channel('oss_log')->debug('oss callback check', [$e->getMessage()]);
            return false;
        }
    }
    
    /**
     * @param $time
     * @param int $exp
     * @return bool
     */
    public static function checkTime($time, $exp = 180)
    {
        $time = (int)$time;
        $now = time();
        return ($now - $time <= $exp);
    }
}