<?php

namespace App\Traits\User;

use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait TempAuthCodeTrait
{
    /**
     * 设置临时授权码
     * @param int $userId
     * @param string $code
     * @param int $ttl 分钟
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function setTempAuthCode($userId, $code = '', $ttl = 3)
    {
        if (empty($code)) {
            $code = Str::random();
        }
        $ttl = now()->addMinutes($ttl);
        $this->tempAuthCodeCache()->set($userId, $code, $ttl);
        return [$code, $ttl->toDateTimeString()];
    }

    /**
     *  获取临时授权码
     * @param int $userId
     * @return array|mixed
     */
    public function getTempAuthCode($userId)
    {
        return $this->tempAuthCodeCache()->get($userId);
    }

    /**
     * @return TaggedCache
     */
    public function tempAuthCodeCache()
    {
        return Cache::tags('users.tempAuthCode');
    }
}
