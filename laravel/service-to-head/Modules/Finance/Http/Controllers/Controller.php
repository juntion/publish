<?php

namespace Modules\Finance\Http\Controllers;

use Modules\Base\Http\Controllers\Controller as BaseController;
use Modules\Permission\Exceptions\UnauthorizedException;

class Controller extends BaseController
{
    /**
     * @param $user
     * @param $permission
     * @throws UnauthorizedException
     */
    protected function checkPermission($user, $permission)
    {

        if(is_null($user) || !$user->hasPermissionTo($permission)) {
            throw UnauthorizedException::forPermissions($permission);
        }
    }
}
