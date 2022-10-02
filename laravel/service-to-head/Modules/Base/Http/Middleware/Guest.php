<?php

namespace Modules\Base\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Exceptions\Auth\UnGuestException;

class Guest
{
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard) {
            Auth::shouldUse($guard);
        }

        if (Auth::guard($guard)->check()) {
            throw new UnGuestException(__('base::auth.unGuest'));
        }

        return $next($request);
    }
}
