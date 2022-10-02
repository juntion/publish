<?php

namespace Modules\Permission\Exceptions;

use  Modules\Base\Exceptions\BaseException;

class RoleDoesNotExist extends BaseException
{
    public static function named($name)
    {
        return new static(__('permission::role.noRoleName', ['name' => $name]));
    }

    public static function withUuid($uuid)
    {
        return new static(__('permission::role.noRoleUuid', ['uuid' => $uuid]));
    }
}
