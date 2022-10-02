<?php

namespace App\Rpc;

use Hprose\Http\Client;
use Hprose\Future;
use Symfony\Component\HttpFoundation\Response;

class RpcClient
{
    protected $address;
    protected $username;
    protected $password;

    public function __construct($address, $username, $password)
    {
        $this->address = $address;
        $this->username = $username;
        $this->password = $password;
    }

    public function getRpcClient()
    {
        $client = new Client($this->address, false);
        // 设置RPC服务账号及密码
        $client->setHeader('username', $this->username);
        $client->setHeader('password', $this->password);
        $client->addInvokeHandler([self::class, 'handle']);
        return $client;
    }

    public static function handle($name, array &$args, \stdClass $context, \Closure $next)
    {
        $response = $next($name, $args, $context);

        if ($response['status'] === 'error') {
            switch ($response['code']) {
                case 401:// 未授权
                    throw new \Exception($response['message'], Response::HTTP_UNAUTHORIZED);
                    break;
                default:
                    break;
            }
        }

        // 得到返回的Future/Promise对象的状态和数据
        $data = Future\resolve($response['data'])->inspect();
        return $data['value'];
    }

    public function logout($userId, $token)
    {
        $res = $this->getRpcClient()->logout($userId, $token);
        //dd($res);
        if ($res['status'] == 'success') {
            return true;
        }
        \Log::error('rpc logout error', [$res]);
        return false;
    }

    public function reLogin($md5OldToken)
    {
        $res = $this->getRpcClient()->reLogin($md5OldToken);
        if ($res['status'] == 'success') {
            return true;
        }
        logger()->error('rpc reLogin error', [$res]);
        return false;
    }

    public function refreshToken($md5OldToken, $newToken)
    {
        $res = $this->getRpcClient()->refreshToken($md5OldToken, $newToken);
        if ($res['status'] == 'success') {
            return true;
        }
        logger()->error('rpc refresh token error', [$res]);
        return false;
    }

    /**
     * ERP服务
     */
    public static function erpClient()
    {
        $client = new self(config('app.rpc_info.erp.address'), config('app.rpc_info.erp.username'), config('app.rpc_info.erp.password'));
        return $client->getRpcClient();
    }

    /**
     * ERP User服务
     * @return \Hprose\Proxy|mixed
     */
    public static function user()
    {
        return self::erpClient()->User;
    }

    /**
     * ERP Department服务
     * @return \Hprose\Proxy|mixed
     */
    public static function department()
    {
        return self::erpClient()->Department;
    }

    /**
     * ERP Permission服务
     * @return \Hprose\Proxy|mixed
     */
    public static function permission()
    {
        return self::erpClient()->Permission;
    }

    public static function company()
    {
        return self::erpClient()->Company;
    }
}
