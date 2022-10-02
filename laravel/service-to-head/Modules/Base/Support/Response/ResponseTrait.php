<?php

namespace Modules\Base\Support\Response;

use Symfony\Component\HttpFoundation\Response as FoundationResponse;

trait ResponseTrait
{
    use ResponseStatusTrait;

    /*
    |--------------------------------------------------------------------------
    | api 响应
    |--------------------------------------------------------------------------
    |api 响应格式说明
    |{
    |   "status":"",   必须返回，只能为 success 或者 error
    |   "code":"",     必须返回，应用返回的状态码，三位数的状态码和http状态码一致，自定义状态码从 1000 开始
    |   "message":"",  可选返回，作为请求成功 或者 失败的一个备注说明
    |   "data":"",     可选返回，请求成功需要返回数据时返回
    |   "errors":""    可选返回，请求失败返回的具体错误信息说明
    |}
    |
    */

    public function success($code = FoundationResponse::HTTP_OK)
    {
        return response()->json([
            'status' => self::$successStatus,
            'code' => $code,
        ], $code);
    }

    public function successWithMessage($message = '', $code = FoundationResponse::HTTP_OK)
    {
        $message = $message ?: __('base::base.successDo');
        return response()->json([
            'status' => self::$successStatus,
            'code' => $code,
            'message' => $message,
        ], $code);
    }

    public function successWithData($data, $code = FoundationResponse::HTTP_OK)
    {
        return response()->json([
            'status' => self::$successStatus,
            'code' => $code,
            'data' => $data,
        ], $code);
    }

    public function successWithDataAndMessage($data, $message = '', $code = FoundationResponse::HTTP_OK)
    {
        $message = $message ?: __('base::base.successDo');
        return response()->json([
            'status' => self::$successStatus,
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function failed($code = FoundationResponse::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'status' => self::$errorStatus,
            'code' => $code,
        ], $code);
    }

    public function failedWithMessage($message, $code = FoundationResponse::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'status' => self::$errorStatus,
            'code' => $code,
            'message' => $message,
        ], $code);
    }

    public function failedWithMessageAndErrors($errors, $message, $code = FoundationResponse::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'status' => self::$errorStatus,
            'code' => $code,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }

    public function createSuccess($data = [], $message = '', $code = FoundationResponse::HTTP_CREATED)
    {
        $message = $message ?: __('base::base.successCreate');
        return $this->successWithDataAndMessage($data, $message, $code);
    }

    public function updateSuccess($data = [], $message = '')
    {
        $message = $message ?: __('base::base.successUpdate');
        return $this->successWithDataAndMessage($data, $message);
    }

    public function deleteSuccess($message = '')
    {
        $message = $message ?: __('base::base.successDelete');
        return $this->successWithMessage($message);
    }
}
