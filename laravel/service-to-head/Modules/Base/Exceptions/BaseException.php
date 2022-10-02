<?php

namespace Modules\Base\Exceptions;

use Exception;
use Throwable;
use Symfony\Component\HttpFoundation\Response;
use Modules\Base\Support\Response\ResponseTrait;

class BaseException extends Exception
{
    use ResponseTrait;

    public function __construct($message = '', $code = Response::HTTP_BAD_REQUEST, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     *
     * 如果你的异常包含只有在特定条件才会出现的自定义报告逻辑，需要告知 Laravel 使用默认的异常处理配置报告这个异常。要实现这个功能，可以从异常的 report 方法中返回 false
     *
     * 默认不报告异常,自定义报告异常，不需要返回值
     * return false; 告知 Laravel 使用默认的异常处理配置报告这个异常。
     */
    public function report()
    {
        //
    }

    /**
     *
     * 默认返回错误响应
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return $this->failedWithMessage(
            $this->getMessage() ?: __('base::error.exception'),
            Response::HTTP_BAD_REQUEST
        );
    }

}
