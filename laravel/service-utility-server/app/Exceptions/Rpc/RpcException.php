<?php

namespace App\Exceptions\Rpc;

use App\Traits\ResponseTrait;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class RpcException extends Exception
{
    use ResponseTrait;

    public function render($request)
    {
        $code = $this->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR;
        return $this->failedWithMessage('[RPC]' . __($this->getMessage()), $code);
    }
}
