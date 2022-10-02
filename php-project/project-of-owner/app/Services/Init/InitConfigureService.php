<?php


namespace App\Services\Init;

use App\Models\Configuration;
use App\Models\productTypeLayout;
use App\Services\BaseService;
use App\Services\Common\Redis\RedisService;

/**
 * 网站config 数据配置
 *
 * @author aron
 * @date 2020.5.26
 * Class InitConfigureService
 * @package App\Services\Init
 */
class InitConfigureService extends BaseService
{
    protected $cachePrefix = 'globalConfig'; //redis 缓存 前缀
    protected $cacheKey = "configure"; // redis 缓存key
    protected $configModel; // configuration 表
    protected $productConfigModel; //product_type_layout表

    public function __construct()
    {
        parent::__construct();
        $this->configModel = new Configuration();
        $this->productConfigModel = new productTypeLayout();
    }

    /**
     * 获取缓存数据
     *
     * @return array|string
     */
    protected function getConfigure()
    {
        $data = RedisService::getRedisKeyValue($this->cacheKey, $this->cachePrefix);
        if (empty($data)) {
            $config = $this->configModel->select(['configuration_key', 'configuration_value'])->get()->toArray();
            $productConfig = $this->productConfigModel->select(['configuration_key', 'configuration_value'])->get()
                ->toArray();
            $data = array_merge($config, $productConfig);
            RedisService::setRedisKeyValue($this->cacheKey, $data, 0, $this->cachePrefix);
        }
        return $data;
    }

    /**
     * 清楚缓存数据
     *
     * @return $this
     */
    public function removeCache()
    {
        RedisService::removeRedisByKey($this->cacheKey, $this->cachePrefix);
        return $this;
    }

    /**
     * 生成常量配置
     *
     * @return $this
     */
    public function createConfig()
    {
        $data = $this->getConfigure();
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if (!empty($value['configuration_key'])) {
                    define(strtoupper($value['configuration_key']), $value['configuration_value']);
                }
            }
        }
        return $this;
    }
}
