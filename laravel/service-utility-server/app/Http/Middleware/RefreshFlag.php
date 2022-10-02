<?php

namespace App\Http\Middleware;

use App\Traits\RefreshFlagTrait;
use Closure;
use Illuminate\Support\Facades\Route;

class RefreshFlag
{
    use RefreshFlagTrait;

    // 排除登录用到的接口
    protected $except = [
        'login.public',
        'subsystems.guardNames.public',
        'medias.download.public',
        'rpc.public',
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (!in_array(Route::currentRouteName(), $this->except) && method_exists($response, 'header')) {
            $response->header('Refresh-Flag', $this->getRefreshFlag());
        }

        return $response;
    }
}
