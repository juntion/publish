<?php

namespace App\Exceptions\Project;

use App\Traits\ResponseTrait;
use Exception;
use Throwable;

class ProjectPermissionException extends Exception
{
    use ResponseTrait;
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render()
    {
        return $this->failedWithMessage($this->getMessage());
    }
}
