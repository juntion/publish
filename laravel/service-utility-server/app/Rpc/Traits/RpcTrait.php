<?php

namespace App\Rpc\Traits;

trait RpcTrait
{
    /**
     * @param array $data
     * @return array
     */
    protected static function success($data = [])
    {
        return [
            'status' => 'success',
            'code' => 200,
            'data' => $data,
        ];
    }

    /**
     * @param $message
     * @param int $code
     * @return array
     */
    protected static function failed($message, $code = 400)
    {
        return [
            'status' => 'error',
            'code' => $code,
            'message' => $message,
        ];
    }
}
