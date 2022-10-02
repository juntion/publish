<?php

namespace App\Config;

use App\Traits\TransTrait;

/**
 * database config
 *
 * @author aron
 * @date 2019.11.8
 * Trait DataBaseConfig
 * @package App\Config
 */
trait DataBaseConfig
{
    use TransTrait;
    public $config;

    public static function mysql()
    {
        return [
            //读写分离
            'default'   => [
                'driver'    => defined("DB_TYPE") ? DB_TYPE : "mysql",
                'read'      => [
                    [
                        'host'     => defined("DB_SERVER_READ") ? DB_SERVER_READ : "",
                        'database' => defined("DB_DATABASE_READ") ? DB_DATABASE_READ : "fiberstore_spain",
                        'username' => defined("DB_SERVER_USERNAME_READ") ? DB_SERVER_USERNAME_READ : "fstest",
                        'password' => defined("DB_SERVER_PASSWORD_READ") ? DB_SERVER_PASSWORD_READ : "fstest",
                    ]
                ],
                'write'     => [
                    [
                        'host'     => defined("DB_SERVER") ? DB_SERVER : "",
                        'database' => defined("DB_DATABASE") ? DB_DATABASE : "fiberstore_spain",
                        'username' => defined("DB_SERVER_USERNAME") ? DB_SERVER_USERNAME : "fstest",
                        'password' => defined("DB_SERVER_PASSWORD") ? DB_SERVER_PASSWORD : "fstest",
                    ]
                ],
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => "",
            ],
            //只查写库
            'onlyWrite' => [
                'driver'    => defined("DB_TYPE") ? DB_TYPE : "mysql",
                'host'      => defined("DB_SERVER") ? DB_SERVER : "",
                'database'  => defined("DB_DATABASE") ? DB_DATABASE : "fiberstore_spain",
                'username'  => defined("DB_SERVER_USERNAME") ? DB_SERVER_USERNAME : "fstest",
                'password'  => defined("DB_SERVER_PASSWORD") ? DB_SERVER_PASSWORD : "fstest",
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => "",
            ],
//            // 后台数据库
//            'adminDatabase' => [
//                'driver'    => defined("DB_TYPE") ? DB_TYPE : "mysql",
//                'host'      => defined("C_DB_SERVER") ? C_DB_SERVER : "120.77.178.48:13307",
//                'database'  => defined("C_DB_DATABASE") ? C_DB_DATABASE : "fiberstore_spain",
//                'username'  => defined("C_DB_SERVER_USERNAME") ? C_DB_SERVER_USERNAME : "fs_beta",
//                'password'  => defined("C_DB_SERVER_PASSWORD") ? C_DB_SERVER_PASSWORD : "feisu.com17",
//                'charset'   => 'utf8',
//                'collation' => 'utf8_unicode_ci',
//                'prefix'    => "",
//            ],
            //只查写库
            'community' => [
                'driver'    => defined("DB_TYPE") ? DB_TYPE : "mysql",
                'host'      => defined("COMMUNITY_DB_SERVER") ? COMMUNITY_DB_SERVER : "",
                'database'  => defined("COMMUNITY_DB_DATABASE") ? COMMUNITY_DB_DATABASE : "fs_blog",
                'username'  => defined("COMMUNITY_DB_SERVER_USERNAME") ? COMMUNITY_DB_SERVER_USERNAME : "fstest",
                'password'  => defined("COMMUNITY_DB_SERVER_PASSWORD") ? COMMUNITY_DB_SERVER_PASSWORD : "fstest",
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => "",
            ],
        ];
    }

    /**
     * redis 配置 后期会用到
     *
     * @return array
     * @author rebirth
     * @date 2019.12.05
     */
    public static function redis()
    {
        return [
            'host'     => self::trans('REDIS_HOST'),
            'port'     => self::trans('REDIS_PORT'),
            'password' => self::trans('REDIS_PASSWORD'),
            'database' => self::trans('REDIS_SELECT_DB'),
            'prefix'   => self::trans('REDIS_PREFIX'),
        ];
    }
}
