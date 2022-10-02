<?php

namespace App\Http\Controllers;

use App\Support\WsGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GatewayWorkerController extends Controller
{
    public function bind(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
        ]);
        $clientId = $request->get('client_id');
        $user = Auth::user();
        $accessToken = Auth::getToken()->get();
        WsGateway::setSession($clientId, ['access_token' => $accessToken]);
        WsGateway::bindUid($clientId, $user->id);
        WsGateway::joinGroup($clientId, md5($accessToken));
        return $this->success();
    }

    public function webSocket() {
        if (isTesting()){
            return view('webSocket');
        }

        return view('welcome');
    }

    public function push(Request $request) {
        if (isTesting() && WsGateway::isOnline($request->get('client_id', ''))) {
            WsGateway::sendToClient($request->get('client_id'), $request->get('message'));
            return response()->json([
                'status' => "success",
                "message" => "推送成功",
            ]);
        }
        return response()->json([
            'status' => "error",
            "message" => "推送失败：client_id 不在线，或当前环境为生产环境，不允许测试。"
        ]);
    }
}
