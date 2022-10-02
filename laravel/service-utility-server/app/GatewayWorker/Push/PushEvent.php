<?php
/**
 * Created by PhpStorm.
 * User: King
 * Date: 2020/6/9
 * Time: 23:50
 */

namespace App\GatewayWorker\Push;


use App\GatewayWorker\GatewayWorkerEvents;
use App\Support\WsGateway;
use Tymon\JWTAuth\Facades\JWTAuth;

class PushEvent extends GatewayWorkerEvents
{
    public static function onMessage($client_id, $message)
    {
        $message = @json_decode($message, true);
        if ($message && !empty($message['type']) && method_exists(static::class, $message['type'])) {
            static::{$message['type']}($client_id, $message);
        } else {
            WsGateway::sendToClient($client_id, ['type' => 'close']);
        }
    }

    public static function ping($client_id, $message) {
        $guardName = $message['guard_name'] ?? '';
        switch ($guardName) {
            case 'uums':
                $session = WsGateway::getSession($client_id);
                $accessToken = $session['access_token'] ?? null;
                // 没有 token 或 token 校验失败
                if (empty($accessToken) || !JWTAuth::setToken($accessToken)->check()) {
                    // 通知客户端断开连接
                    WsGateway::sendToClient($client_id, ['type' => 'close']);
                }
                break;
            case 'erp':
                break;
            default:
                break;
        }
    }
}