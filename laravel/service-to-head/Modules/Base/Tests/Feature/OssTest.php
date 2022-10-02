<?php

namespace Modules\Base\Tests\Feature;

use Illuminate\Support\Str;
use Modules\Base\Entities\Base\OssTempUpload;
use Modules\Base\Services\Oss\OssCallbackAuth;
use Modules\Base\Tests\AdminTestCase;

class OssTest extends AdminTestCase
{
    private static $ossPermissionUploadUri = 'base/oss/permission/upload';
    private static $ossGetSignUrlUri = 'base/oss/signUrl?object=image/80/d3e54ea7d83540e699eb7bc5f47e8060.jpg';
    private static $ossCallbackUri = 'base/oss/callback/upload';

    public function testOssPermissionUpload()
    {
        $this->postJson(self::$ossPermissionUploadUri, ['mime_type' => 'image/jpeg', 'file_ext' => 'jpg'])->assertSuccessful()->assertJsonStructure([
            'data' => ['token', 'accessid', 'host', 'policy', 'signature', 'expire', 'callback', 'object']
        ]);
    }

    public function testOssGetSignUrl()
    {
        $this->getJson(self::$ossGetSignUrlUri)->assertSuccessful()->assertJsonStructure(['data' => ['url']]);
    }

    public function testOssCallback()
    {
        $obj = 'image/80/' . Str::uuid()->getHex()->toString() . '.jpg';
        $response = $this->post(self::$ossCallbackUri, [
            'object' => $obj,
            'bucket' => 'fsbuck',
            'size' => '8014',
            'token' => OssCallbackAuth::getToken($obj)
        ], ['content-type' => 'application/x-www-form-urlencoded'])->assertSuccessful()->assertJsonStructure([
            'data' => ['object', 'bucket', 'url', 'uuid']
        ]);
        $data = json_decode($response->content(), true);
        OssTempUpload::query()->whereKey($data['data']['uuid'])->delete();
    }
}
