<?php


namespace Modules\Share\Exceptions;


use Modules\Base\Exceptions\BaseException;

class TagException extends BaseException
{
    public function report()
    {
        if($this->getPrevious()){
            return false;
        }
    }
}
