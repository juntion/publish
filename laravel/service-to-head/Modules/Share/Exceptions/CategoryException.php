<?php


namespace Modules\Share\Exceptions;


use Modules\Base\Exceptions\BaseException;

class CategoryException extends BaseException
{
    public function report()
    {
        if($this->getPrevious()){
            return false;
        }
    }
}
