<?php

namespace App\Exceptions\System;

use App\Traits\ResponseTrait;
use Exception;

class InvalidArgumentsException extends Exception
{
    use ResponseTrait;

    public function render($request)
    {
        return $this->failedWithMessage($this->getMessage());
    }
}