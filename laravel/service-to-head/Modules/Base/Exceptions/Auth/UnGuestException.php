<?php

namespace Modules\Base\Exceptions\Auth;

use Exception;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use Modules\Base\Support\Response\ResponseTrait;

class UnGuestException extends Exception
{
    use ResponseTrait;

    /**
     * 访客异常，如果已经登录，则抛这个异常
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct($message =  'unGuest' , $code = FoundationResponse::HTTP_CONFLICT, \Throwable $previous = null)
    {
        parent::__construct($message,$code,$previous);
    }

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return $this->failedWithMessage($this->getMessage(),$this->getCode());
    }

}
