<?php

namespace Modules\Base\Support\Oss;


use Illuminate\Support\Str;

trait OssUtils
{
    /**
     * 设置STS token的权限
     *
     * @return array
     */
    public function STSPolicy($bucket)
    {
        return  [
            'Statement' => [
                [
                    'Action' => [
                        'oss:PutObject', // 仅上传的权限
                    ],
                    'Effect' => 'Allow',
                    'Resource' => [
                        'acs:oss:*:*:' . $bucket,
                        'acs:oss:*:*:' . $bucket . '/*',
                    ]
                ]
            ],
            'Version' => '1'
        ];
    }
    
    public function objectName($mime, $ext)
    {
        $fileType = substr($mime, 0, strpos($mime, '/'));
        $randPrefix = dechex(random_int(0, 15)) . dechex(random_int(0, 15));
        $obj = $fileType . '/' . $randPrefix . '/' . Str::uuid()->getHex()->toString() . '.' . $ext;
        return $obj;
    }
    
    public function ossUrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
