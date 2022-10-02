<?php

namespace Modules\Base\Support\JWTAuth;

use Illuminate\Support\Facades\Redis;

/**
 * Created by PhpStorm.
 * User: fly
 * Date: 2020/3/11
 * Time: 17:51
 */
trait JWTSubjectTrait
{
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return ['ver' => $this->getJWTVersion()];
    }

    public function initJWTVersion()
    {
        Redis::HSETNX($this->getJWTVersionStoreKey(), $this->getKey(), 0);
    }

    public function getJWTVersion()
    {
        return Redis::HGET($this->getJWTVersionStoreKey(), $this->getKey());
    }

    public function incrementJWTVersion()
    {
        return Redis::HINCRBY($this->getJWTVersionStoreKey(), $this->getKey(), 1);
    }

    public function destroyJWTVersion()
    {
        Redis::HDEL($this->getJWTVersionStoreKey(), $this->getKey());
    }

    public function getJWTVersionStoreKey()
    {
        return static::class . ':JWTVersionStoreKey';
    }

    public static function bootJWTSubjectTrait()
    {
        static::created(function ($model) {
            $model->initJWTVersion();
        });
        static::deleting(function ($model) {
            $model->destroyJWTVersion();
        });
    }
}
