<?php
return [
    'access_key_id' => env('ALIYUN_ACCESS_KEY_ID'),
    'access_key_secret' => env('ALIYUN_ACCESS_KEY_SECRET'),
    'endpoint' => env('ALIYUN_OSS_ENDPOINT'),
    'bucket' => env('ALIYUN_OSS_BUCKET'),
    'bucket_host' => env('ALIYUN_OSS_BUCKET_HOST'),
    'ram_arn' => env('ALIYUN_RAM_ARN'),
    'sts_host' => env('ALIYUN_STS_HOST'),
    'watermark_base64' => env('WATER_MARK_BASE64'),
    'token_timeout' => env('OSS_TOKEN_TIMEOUT', 3600),
];
