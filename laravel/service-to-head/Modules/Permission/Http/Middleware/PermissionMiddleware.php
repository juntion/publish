<?php

namespace Modules\Permission\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Modules\Permission\Exceptions\UnauthorizedException;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $permission)
    {
        if (app('auth')->guest()) {
            throw new AuthenticationException();
        }

        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);

        $user = app('auth')->user();
        if (method_exists($user, 'hasPermissionTo')) {
            foreach ($permissions as $permission) {
                if ($user->hasPermissionTo($permission)) {
                    return $next($request);
                }
            }
        }

        // @todo 支持权限的 且 验证

        throw UnauthorizedException::forPermissions(implode(",", $permissions));
    }
}
