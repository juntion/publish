<?php

namespace Modules\Tag\Support;


/**
 * 生成签名数据
 * Class Signature
 * @package Modules\Tag\Support
 */
class Signature
{
    protected $token;

    /**
     * Signature constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * 获取签名
     * @return string
     */
    public function get()
    {
        $randStr = $this->rand(20);
        $microtime = microtime(true);
        return md5($this->token . $randStr . $microtime) .
            ':' . $randStr . ':' . $microtime;
    }

    /**
     * @param int $len
     * @return string
     */
    protected function rand($len = 4)
    {
        $rand = '';
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@-';
        for ($i = 0; $i < $len; $i++) {
            $rand .= $str[rand(0,63)];
        }

        return $rand;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->get();
    }
}