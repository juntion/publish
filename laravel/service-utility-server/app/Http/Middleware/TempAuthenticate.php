<?php

namespace App\Http\Middleware;

use App\Traits\User\TempAuthCodeTrait;
use Closure;
use Illuminate\Auth\AuthenticationException;

class TempAuthenticate
{
    use TempAuthCodeTrait;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userId = $request->input('userId');
        $authCode = $request->input('tempAuthCode');
        if (empty($userId) || empty($authCode) || $authCode != $this->getTempAuthCode($userId)) {
            throw new AuthenticationException();
        }
        return $next($request);
    }
}
