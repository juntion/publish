<?php

namespace Modules\ERP\Exceptions;

use Modules\Base\Exceptions\BaseException;


class OrderException extends BaseException
{
    public function report()
    {
        if($this->getPrevious()){
            return false;
        }
    }
}
