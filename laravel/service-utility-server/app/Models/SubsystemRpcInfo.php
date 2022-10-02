<?php

namespace App\Models;

use App\Rpc\RpcClient;
use Illuminate\Database\Eloquent\Model;

class SubsystemRpcInfo extends Model
{
    /**
     * @return \Generator
     * @author: King
     * @version: 2020/7/2 11:37
     */
    public static function getRpcClients()
    {
        $rpcInfo = config('app.rpc_info');
        foreach ($rpcInfo as $sys => $info) {
            if (empty($info['address'])) continue;
            yield $sys => new RpcClient($info['address'], $info['username'], $info['password']);
        }
    }
}
