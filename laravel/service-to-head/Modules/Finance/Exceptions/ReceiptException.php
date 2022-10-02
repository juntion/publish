<?php


namespace Modules\Finance\Exceptions;


use Modules\Base\Exceptions\BaseException;

class ReceiptException extends BaseException
{
    public function report()
    {
        if($this->getPrevious()){
            return false;
        }
    }
}
