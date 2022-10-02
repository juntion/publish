<?php


namespace App\Exception;

use Throwable;

class UndefinedCustomersException extends \ Exception
{
    /**
     * @return mixed
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message ? $message : "customer id not defined";
        parent::__construct($message, $code, $previous);
    }
}
