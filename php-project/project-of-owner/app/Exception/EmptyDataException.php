<?php


namespace App\Exception;

use Throwable;

class EmptyDataException extends \Exception
{
    /**
     * @return mixed
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message ? $message : "data is empty";
        parent::__construct($message, $code, $previous);
    }
}
