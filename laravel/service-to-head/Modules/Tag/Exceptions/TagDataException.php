<?php

namespace Modules\Tag\Exceptions;

use Modules\Base\Exceptions\BaseException;

class TagDataException extends BaseException
{
    public function report()
    {
        if ($this->getPrevious()) {
            return false;
        }
    }
}
