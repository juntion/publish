<?php

namespace App\Exceptions\System;

use App\Traits\ResponseTrait;
use Exception;
use Throwable;

class InvalidStatusException extends Exception
{
    use ResponseTrait;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message !== '' ? $message : __('error.denied');
        parent::__construct($message, $code, $previous);
    }

    public function render($request)
    {
        return $this->failedWithMessage($this->getMessage());
    }
}
