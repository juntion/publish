<?php


namespace App\Config;

use App\Traits\TransTrait;

class AvaTaxConfig
{
    use TransTrait;
    public $config;

    /**
     *
     * @param bool $isTest 是否测试环境
     * @return array
     */
    public static function avaTax($isTest = false)
    {
        if ($isTest) {
            return [
                'userName' => "Aron.Yao@feisu.com", //用户名
                'userPassword' => "yaowei110", //密码
                'appName' => 'FS',
                'appVersion' => '1.0',
                'machineName' => 'www.fs.com',
                'enviroment' => 'production', //开发环境
                'accountId' => '2000176385',
                'licenseKey'  => 'CB939505F454DC4C'
            ];
        } else {
            return [
                'userName' => "Aron.Yao@feisu.com", //用户名
                'userPassword' => "yaowei110", //密码
                'appName' => 'FS',
                'appVersion' => '1.0',
                'machineName' => 'www.fs.com',
                'enviroment' => 'production', //开发环境
                'accountId' => '2000176385',
                'licenseKey'  => 'CB939505F454DC4C'
            ];
        }
    }

    public static function avaTaxExemption()
    {
        return [
            'userName' => 'FSAPI',
            'password' => 'Yaowei110!'
        ];
    }
}
