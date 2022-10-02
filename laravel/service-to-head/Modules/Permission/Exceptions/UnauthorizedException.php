<?php

namespace Modules\Permission\Exceptions;

use  Modules\Base\Exceptions\BaseException;

class UnauthorizedException extends BaseException
{
    public static function forPermissions($name)
    {
        return new static(__('permission::permission.forPermissions', ['name' => $name]), 403);
    }
}
