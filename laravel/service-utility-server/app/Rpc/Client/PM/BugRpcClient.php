<?php

namespace App\Rpc\Client\PM;

use App\Contracts\Rpc\BugRpcInterface;
use App\Exceptions\Rpc\RpcException;
use App\Rpc\RpcClient;

class BugRpcClient implements BugRpcInterface
{
    /**
     * @return \Hprose\Proxy|mixed
     */
    private static function getClient()
    {
        return RpcClient::erpClient()->Bug;
    }

    /**
     * 同步状态
     * @param string $erpBugNumber
     * @param int $status
     */
    public function syncStatus(string $erpBugNumber, int $status)
    {
        try {
            return self::getClient()->status($erpBugNumber, $status);
        } catch (\Exception $e) {
            throw  new RpcException($e->getMessage(), $e->getCode());
        }
    }
}
