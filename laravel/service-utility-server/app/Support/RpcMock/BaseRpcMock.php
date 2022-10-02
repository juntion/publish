<?php

namespace App\Support\RpcMock;

class BaseRpcMock
{
    /**
     * @param array $data
     * @return array
     */
    public function success($data = [])
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
    public function failed($message = '', $code = 400)
    {
        return [
            'status' => 'error',
            'code' => $code,
            'message' => $message,
        ];
    }
}
