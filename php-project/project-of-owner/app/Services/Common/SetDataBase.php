<?php


namespace App\Services\Common;

use App\Services\BaseService;
use App\Services\Common\Redis\RedisReload;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Config\DataBaseConfig;

/**
 * 设置数据库配置
 *
 * Class SetDataBase
 * @package App\Services\Common
 */
class SetDataBase extends BaseService
{
    use DataBaseConfig;

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * 注册eloquent查询
     *
     * @author aron
     * @date 2019.11.8
     */
    public static function setConfig()
    {
        $capsule = new Capsule;
        $config = self::mysql();
        $default = $config['default'];
        $write = $config['onlyWrite'];
        $community = $config['community'];
//        $admin = $config['adminDatabase'];
        $isWriteConfig = self::trans('DB_READ_SERVER_ENABLE');
        if ($isWriteConfig) {
            $capsule->addConnection($default, 'default');
        } else {
            $capsule->addConnection($write, 'default');
        }
        $capsule->addConnection($community, 'community');
        $capsule->addConnection($write, 'write');
//        $capsule->addConnection($admin, 'adminDatabase');
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        return $capsule;
    }

    /**
     * 初始化redis
     *
     * @return RedisReload|null
     * @author rebirth
     * @date 2019.12.05
     */
    public static function setRedis()
    {
        return RedisReload::getInstance(self::redis());
    }
}
