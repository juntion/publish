<?php

namespace App\Http\Controllers\Rpc;

use App\Http\Controllers\Controller;
use App\Rpc\RpcHandel;
use Illuminate\Http\Request;

class RpcController extends Controller
{
    public function rpc(Request $request, RpcHandel $rpcHandel)
    {
        $rpcHandel->start();
    }
}
