<?php

namespace Modules\Permission\Exceptions;

use InvalidArgumentException;
use Illuminate\Support\Collection;

class GuardDoesNotMatch extends InvalidArgumentException
{
    public static function create(string $givenGuard, Collection $expectedGuards)
    {
        return new static(__('permission::role.guardError', ['guards' => $expectedGuards->implode(', '), 'guard' => $givenGuard]));
    }
}
