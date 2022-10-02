<?php

namespace Modules\Finance\Exceptions;

use Modules\Base\Exceptions\BaseException;

class InvoiceException extends BaseException
{
    public function report()
    {
        if($this->getPrevious()){
            return false;
        }
    }
}
