<?php

namespace Modules\Permission\Exceptions;

use InvalidArgumentException;

class PermissionDoesNotExist extends InvalidArgumentException
{
    public static function named(string $permissionName, string $guardName = '')
    {
        return new static(__('permission::permission.noPermissionName', ['name' => $permissionName, 'guard'=>$guardName]));
    }

    public static function withUuid($uuid)
    {
        return new static(__('permission::permission.noPermissionUuid', ['uuid' => $uuid]));
    }
}
