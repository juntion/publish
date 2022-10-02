<?php

namespace App\Listeners;

use App\Events\LogoutEvent;
use App\Models\AccessToken;
use App\Models\SubsystemRpcInfo;
use App\Models\User;
use App\Support\WsGateway;
use Illuminate\Support\Facades\Redis;

class LogoutListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param LogoutEvent $event
     * @return void
     */
    public function handle(LogoutEvent $event)
    {
        $userId = $event->userId;
        $from = $event->from;
        // erp admin_id => origin_id
        if ($from == 'erp') {
            $userId = User::query()->where('origin_id', $userId)->first()->id;
        }

        // 通知各系统注销登录
        foreach (SubsystemRpcInfo::getRpcClients() as $rpcClient) {
            $rpcClient->logout($userId, $event->token);
        }

        // 退出sso系统，并删除token
        if (!auth()->check()){
            // 若已是过期状态，设置刷新标识，使其能够加入黑名单禁止其刷新 Token
            auth()->manager()->setRefreshFlow();
        }
        auth()->setToken($event->token)->invalidate(); // 将 Token 加入黑名单
        AccessToken::query()->where([['user_id', $userId], ['access_token', $event->token]])->delete();

        //删除redis登录记录，目前此登录记录无实际意义
        Redis::connection()->hDel('user_login_systems', ["{$userId}_uums", "{$userId}_erp"]);

        // 通知客户端断开连接
        WsGateway::sendToGroup(md5($event->token), ['type' => 'logout']);
    }
}
