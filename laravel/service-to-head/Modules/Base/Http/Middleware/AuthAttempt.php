<?php

namespace Modules\Base\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthAttempt extends Middleware
{
    /**
     * 可以使用多个guard来尝试认证，认证通过与否都可以
     */

    public function handle($request, Closure $next, ...$guards)
    {
        $this->attemptAuth($request, $guards);

        return $next($request);
    }

    /**
     * 尝试登录，用于登录和不登录都可以访问的接口。
     * @param $request
     * @param array $guards
     * @return mixed
     */
    protected function attemptAuth($request, array $guards)
    {
        if (empty($guards)) {
            $guards = config('auth.guards');
            $guards = array_keys($guards);
        }
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                $this->auth->shouldUse($guard);

                if (app()->runningUnitTests()) {
                    return;
                }

                // 服务器和token的载荷上的版本号不相同则视为 token 无效
                $currentVersion = $this->auth->guard($guard)->user()->getJWTVersion();
                $tokenVersion = $this->auth->guard($guard)->getPayload()->get('ver');
                if ($currentVersion == $tokenVersion) {
                    return;
                }

                $this->auth->guard($guard)->logout();
                break;
            }
        }
    }
}
