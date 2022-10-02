<?php

namespace App\Exceptions\Demand;

use App\Traits\ResponseTrait;
use Exception;
use Throwable;

class InvaildParameterException extends Exception
{
    use ResponseTrait;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render($request)
    {
        return $this->failedWithMessage($this->getMessage());
    }
}
