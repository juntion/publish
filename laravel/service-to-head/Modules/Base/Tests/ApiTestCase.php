<?php

namespace Modules\Base\Tests;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Modules\Base\Entities\Base\OpenAuth;

abstract class ApiTestCase extends TestCase
{
    private static $signStr;

    protected function setUp(): void
    {
        parent::setUp();

        $requestHeader= [
            'authorization'=>$this->getSignStr(),
            'Accept'  => 'application/json',
        ];

        $this->withHeaders($requestHeader);
    }

    protected function getSignStr()
    {
        if (!self::$signStr) {
            $openAuth = OpenAuth::where('status', 0)->orderBy('created_at', 'desc')->limit(1)->first();
            if (!$openAuth){
                Artisan::call('php artisan base:open-auth get');
                $openAuth = OpenAuth::where('status', 0)->orderBy('created_at', 'desc')->limit(1)->first();
            }

            # 加密方式
            $accessKeyId = $openAuth->access_key_id;
            $accessKeySecret = $openAuth->access_key_secret;
            $original = [
                'k' => $accessKeyId,        // access key id(授权ID);
                'r' => mt_rand(10000, 99999),    // 自定义随机数,可以自己改成任意随机数
                't' => time(),             // 请求时间戳(单位秒)，值得注意的是，这个时间在服务端鉴权时如果超过60s，则会判断token失效
                'f' => 'fs',               // fs(固定值)
            ];
            $originalStr = http_build_query($original);// k=xxx&r=xxx&t=213213&f=fs
            // 加密规则：使用sha1算法，加密k,r,t,f内容$originalStr，密钥为分配的密钥，将加密后的16进制编码拼接$originalStr后再base64，即为auth token
            self::$signStr = base64_encode(hash_hmac('sha1', $originalStr, $accessKeySecret) . $originalStr);
        }

        return self::$signStr;
    }
}
