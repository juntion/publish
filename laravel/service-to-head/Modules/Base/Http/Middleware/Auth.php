<?php

namespace Modules\Base\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Auth extends Middleware
{
    /**
     * 可以使用多个guard来认证，必须有一个认证通过，否则抛异常
     */

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string[] ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        return $next($request);
    }

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  array $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
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

                break;
            }
        }

        $this->unauthenticated($request, $guards);
    }

}
