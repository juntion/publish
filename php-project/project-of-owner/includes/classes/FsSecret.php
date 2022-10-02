<?php

namespace classes;

class FsSecret
{
    /**
     * 加解密，结合了encrypt方法,加密规则请不要随意改动，会导致旧的加密数据无法解密
     * @param        $string        需要加解密的字符串
     * @param        $operation     'DECODE'  解密  其他字符为加密
     * @param string $key           秘钥
     * @param int    $expiry        密文过期时间
     *
     * @return bool|mixed|string
     */
    public static function authCode($string, $operation, $key = '', $expiry = 0)
    {
        $keyStr = ENCRYPT_KEY;//TODO: 秘钥配置需要调整，根据项目调整
        $keyArray = json_decode($keyStr,true);
        if($operation == 'DECODE'){
            $versionArr = explode('=',$string);
            $versionStr = end($versionArr);
            $version = (int)substr(base64_decode($versionStr),6,-6);
            if($version != 0){
                if(isset($keyArray[$version - 1]) && $keyArray[$version - 1]){
                    $key = $keyArray[$version - 1];
                }
            }
            $string = substr($string,0,-(strlen($versionStr) + 1));
        }else{
            if(!$key && !empty($keyArray)){
                $key = end($keyArray);
                $version = sizeof($keyArray);
            }else{
                $version = '0';
            }
            $version = str_replace('=', '', base64_encode(self::charsRand() . $version . self::charsRand()));
        }

        // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
        $ckey_length = 8;
        // 密匙
        $key = md5(md5($key));
        // 密匙a会参与加解密
        $keya = md5(substr($key, 8, 16));
        // 密匙b会用来做数据完整性验证
        $keyb = md5(substr($key, 6, 16));
        // 密匙c用于变化生成的密文
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) :
            substr(md5(microtime()), -$ckey_length)) : '';
        // 参与运算的密匙
        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);
        // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，
        //解密时会通过这个密匙验证数据完整性
        // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
        $string = $operation == 'DECODE' ? base64_decode(substr(substr($string, $ckey_length), 6, -8)) :
            sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 2, 18) . self::encrypt($string, 'E', substr(md5($string . $keyb), 2, 18));
        $string_length = strlen($string);
        $result = '';
        $box = range(0, 255);
        $rndkey = array();
        // 产生密匙簿
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
        // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        // 核心加解密部分
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            // 从密匙簿得出密匙进行异或，再转成字符
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation == 'DECODE') {
            // 验证数据有效性，请看未加密明文的格式
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&
                substr($result, 10, 18) == substr(md5(self::encrypt(substr($result, 28), 'D', substr($result, 10, 18)) . $keyb), 2, 18)
            ) {
                return self::encrypt(substr($result, 28), 'D', substr($result, 10, 18));
            } else {
                return '';
            }
        } else {
            // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
            // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
            return $keyc . self::charsRand() . str_replace('=', '', base64_encode($result)) . self::charsRand(8) . '=' . $version;
        }
    }

    /**
     * 加解密,加密规则请不要随意改动，会导致旧的加密数据无法解密
     * @param        $string      需要加解密的字符串
     * @param        $operation   'E' 加密  'D'  解密
     * @param string $key         秘钥
     *
     * @return bool|mixed|string
     */
    protected static function encrypt($string, $operation, $key = '')
    {
        $keyStr =  ENCRYPT_KEY;//TODO: 秘钥配置需要调整，根据项目调整
        $keyArray = json_decode($keyStr,true);
        if($operation == 'D'){
            $versionArr = explode('=',$string);
            $versionStr = end($versionArr);
            $version = (int)substr(base64_decode($versionStr),6,-6);
            if($version != 0){
                if(isset($keyArray[$version - 1]) && $keyArray[$version - 1]){
                    $key = $keyArray[$version - 1];
                }
            }
            $string = substr($string,0,-(strlen($versionStr) + 1));
        }else{
            if(!$key){
                $key = end($keyArray);
                $version = sizeof($keyArray);
            }else{
                $version = '0';
            }
            $version = str_replace('=', '', base64_encode( self::charsRand() . $version . self::charsRand()));
        }

        $key = md5(md5($key));
        $key_length = strlen($key);
        $string = $operation == 'D' ? base64_decode(substr($string, 8, -6)) : substr(md5($string . $key), 0, 15) . $string;
        $string_length = strlen($string);
        $rndkey = $box = array();
        $result = '';
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($key[$i % $key_length]);
            $box[$i] = $i;
        }
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation == 'D') {
            if (substr($result, 0, 15) == substr(md5(substr($result, 15) . $key), 0, 15)) {
                return substr($result, 15);
            } else {
                return '';
            }
        } else {
            return self::charsRand(8) . str_replace('=', '', base64_encode($result)) . self::charsRand() . '=' . $version;
        }
    }

    /**
     * 随机字符串
     * @param int $len  返回字符串长度
     *
     * @return string
     */
    protected static function charsRand($len = 6){
        $var = '';
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ@-*_';
        $charLen = strlen($chars);
        for ($i = 0; $i < $len; $i++) {
            $rand = rand(0,$charLen-1);
            $var .= $chars[$rand];
        }
        return $var;
    }
}