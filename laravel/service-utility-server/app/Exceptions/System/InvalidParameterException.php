<?php

namespace App\Exceptions\System;

use App\Traits\ResponseTrait;
use Exception;
use Throwable;

class InvalidParameterException extends Exception
{
    use ResponseTrait;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message !== "" ? $message : __('error.invalid_parameter');
        parent::__construct($message, $code, $previous);
    }

    public function render($request)
    {
        return $this->failedWithMessage($this->getMessage());
    }
}
