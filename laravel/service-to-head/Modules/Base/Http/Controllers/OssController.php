<?php

namespace Modules\Base\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Base\Entities\Base\OssTempUpload;
use Modules\Base\Http\Requests\Oss\OssCallbackRequest;
use Modules\Base\Http\Requests\Oss\OssUploadPermissionRequest;
use Modules\Base\Http\Requests\Oss\OssSignUrlRequest;
use Modules\Base\Services\Oss\OssCallbackAuth;
use Modules\Base\Support\Facades\OssService;
use OSS\Core\OssException;

class OssController extends Controller
{
    public function uploadCallback(OssCallbackRequest $request)
    {
        Log::channel('oss_log')->debug('oss callback', ['body' => $request->all(), 'header' => $request->header()]);
        $token = $request->input('token');
        $object = $request->input('object');
        $bucket = $request->input('bucket');
        if (!OssCallbackAuth::check($token, $object)) {
            try {
                OssService::deleteObject($bucket, $object);
            }catch (OssException $ossException) {}
            return $this->failedWithMessage('Illegal request', 401);
        }
        $uuid = Str::uuid()->getHex()->toString();
        OssTempUpload::query()->create([
            'uuid' => $uuid,
            'object' => $object,
            'bucket' => $bucket,
            'origin_body' => $request->all(),
        ]);
        $res = $request->all();
        $res['uuid'] = $uuid;
        $res['url'] = OssService::getSignUrl($object, $bucket);
        return $this->successWithData($res);
    }

    public function getOssUrl(OssSignUrlRequest $request)
    {
        $url = OssService::getSignUrl($request->input('object'));
        return $this->successWithData(['url' => $url]);
    }

    public function uploadPermission(OssUploadPermissionRequest $request)
    {
        $sign = OssService::webUploadPolicy([
            'exp' => 120,
            'mime_type' => $request->input('mime_type'),
            'file_ext' => $request->input('file_ext'),
        ]);
        $sign['token'] = OssCallbackAuth::getToken($sign['object']);
        return $this->successWithData($sign);
    }

    public function stsToken()
    {
        $res = OssService::STSAuthorization();
        return $this->successWithData([
            'security_token' => $res['SecurityToken'],
            'access_key_id' => $res['AccessKeyId'],
            'access_key_secret' => $res['AccessKeySecret'],
            'expiration' => $res['Expiration'],
        ]);
    }
}
