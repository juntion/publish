<?php

namespace Modules\Base\Services\Oss;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Modules\Base\Contracts\Oss\OssService;
use Modules\Base\Support\Oss\OssUtils;
use OSS\Core\OssException;
use OSS\Core\OssUtil;
use OSS\OssClient;

class AliyunOssService implements OssService
{
    use OssUtils;

    protected static $ossClient;
    
    protected static $signUrlTimeout;

    public function __construct()
    {
        if (!config('oss.access_key_id')
            || !config('oss.access_key_secret')
            || !config('oss.endpoint')
            || !config('oss.bucket')
            || !config('oss.bucket_host')
            || !config('oss.ram_arn')
            || !config('oss.sts_host')
        ) {
            throw new OssException('Important configuration information is missing');
        }
    }

    /**
     * 返回原始sdk 客户端接口
     *
     * @return OssClient
     */
    public function client()
    {
        if (static::$ossClient && static::$ossClient instanceof OssClient) {
            return static::$ossClient;
        }
        static::$ossClient = new OssClient(config('oss.access_key_id'),
            config('oss.access_key_secret'),
            config('oss.endpoint'));
        if (!static::$signUrlTimeout) static::$signUrlTimeout = config('oss.token_timeout');
        return static::$ossClient;
    }

    public function bucket(): string
    {
        return config('oss.bucket');
    }

    /**
     * 获取图片缩放的签名url
     * 默认生成等比缩放的高100px的图片
     *
     * @param string $obj 对象名
     * @param string $process 处理方式 详情查看文档https://help.aliyun.com/document_detail/44688.html?spm=a2c4g.11186623.6.736.2b842b31qSfDXc
     * @param bool $isSave
     * @return string
     */
    public function imageResize($obj, string $process = '', bool $isSave = false)
    {
        $options = static::objectProcessOptions('image', '/resize,' . ($process ?: 'h_100,m_lfit'));
        if (!$isSave) {
            return static::getSignUrl($obj, static::bucket(), static::$signUrlTimeout, OssClient::OSS_HTTP_GET, $options);
        } else {
            return static::processObject($obj, $options[OssClient::OSS_PROCESS]);
        }
    }

    /**
     * 获取图片自定义水印签名url
     * 默认生成参数，右下角x轴偏移10px y偏移10px 透明度50%
     *
     * @param string $obj oss对象名
     * @param string $base64Image 水印图片的base64编码
     * @param string $process 自定义处理方式
     * @param bool $isSave
     * @return string
     */
    public function imageWatermark($obj, $base64Image, string $process = '', bool $isSave = false): string
    {
        $options = static::objectProcessOptions('image', '/watermark,image_' . $base64Image . ',' . ($process ?: 'g_se,x_10,y_10,t_50'));
        if (!$isSave) {
            return static::getSignUrl($obj, static::bucket(), static::$signUrlTimeout, OssClient::OSS_HTTP_GET, $options);
        } else {
            return static::processObject($obj, $options[OssClient::OSS_PROCESS]);
        }
    }

    /**
     * @param $process
     * @return array
     */
    public function objectProcessOptions($type, $process)
    {
        return [
            OssClient::OSS_PROCESS => $type . $process,
        ];
    }

    /**
     * 获取签证url
     *
     * @param string $obj oss对象名
     * @param string $bucket
     * @param int $timeout 链接有效时间 单位s
     * @param null $method 请求的方式 仅限 GET | PUT
     * @param null|array $options 其他配置信息
     * @return string
     */
    public function getSignUrl($obj, $bucket = null, $timeout = 600, $method = null, $options = null): string
    {
        return static::client()->signUrl(($bucket ?: static::bucket()), $obj, $timeout, ($method ?: OssClient::OSS_HTTP_GET), $options);
    }

    /**
     * 返回签名信息用于前端post上传
     *
     * @param array $options ['callback' => '自定义回调地址', 'file_ext' => '文件后缀', 'mime_type' => '文件mime类型', 'max_size' => '最大文件大小，字节']
     * @return array
     * @throws OssException
     */
    public function webUploadPolicy(array $options): array
    {
        $host = config('oss.bucket_host');
        // $callbackUrl为上传回调服务器的URL，请将下面的IP和Port配置为您自己的真实URL信息。
        $callbackUrl = $options['callback'] ?? route('base.oss.callback.upload');
        $fileExt = $options['file_ext'] ?? '';
        $mimeType = $options['mime_type'] ?? '';
        $maxSize = $options['max_size'] ?? (1073741824 * 2); // 单位字节 默认2GB
        if (empty($callbackUrl) || empty($fileExt) || empty($mimeType)) {
            throw new OssException('Upload policy missing important parameters!');
        }
        $dir = $this->objectName($mimeType, $fileExt);  // 用户上传文件名 即object name

        $callbackString = json_encode([
            'callbackUrl'      => $callbackUrl,
            'callbackBody'     => 'bucket=${bucket}&object=${object}&size=${size}&mime_type=${mimeType}'
                . '&height=${imageInfo.height}&width=${imageInfo.width}&format=${imageInfo.format}&token=${x:token}',
            'callbackBodyType' => 'application/x-www-form-urlencoded',
        ]);

        $base64CallbackBody = base64_encode($callbackString);
        $expire = Arr::exists($options, 'exp') ? $options['exp'] : 30;  // 设置该policy超时时间. 即这个policy过了这个有效时间，将不能访问。
        $end = time() + $expire;
        $expiration = Carbon::createFromTimestamp($end)->format(\DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos) . 'Z';

        $conditions = [
            ['content-length-range', 0, (int)$maxSize], // 最大文件大小.用户可以自己设置 单位字节
            ['starts-with', '$key', $dir],  // 表示用户上传的数据，必须是以$dir开始，不然上传会失败，这一步不是必须项，只是为了安全起见，防止用户通过policy上传到别人的目录。
        ];

        $policy = json_encode([
            'expiration' => $expiration,
            'conditions' => $conditions,
        ]);
        $base64Policy = base64_encode($policy);
        $signature = base64_encode(hash_hmac('sha1', $base64Policy, config('oss.access_key_secret'), true));
        $response = [];
        $response['accessid'] = config('oss.access_key_id');
        $response['host'] = $host;
        $response['policy'] = $base64Policy;
        $response['signature'] = $signature;
        $response['expire'] = $end;
        $response['callback'] = $base64CallbackBody;
        $response['object'] = $dir;  // oss object name
        return $response;
    }

    /**
     * 删除多个object
     *
     * @param $bucket
     * @param array $objects
     * @param null|array $options
     * @return mixed
     */
    public function deleteObjects($bucket, array $objects, $options = null)
    {
        return static::client()->deleteObjects($bucket, $objects, $options);
    }

    /**
     * 删除指定单个object
     *
     * @param $bucket
     * @param $object
     * @param null|array $options
     * @return mixed
     */
    public function deleteObject($bucket, $object, $options = null)
    {
        return static::client()->deleteObject($bucket, $object, $options);
    }

    /**
     * 视频截帧 (返回的资源链接每访问1w次1块钱)
     * process文档：https://help.aliyun.com/document_detail/64555.html?spm=a2c4g.11186623.6.760.6df4438ewGaNVl
     * t 时间毫秒；f 图片格式 w h 宽高 m 只有fast 表示截取指定时间附近关键的帧
     *
     * @param $obj
     * @param string $process
     * @param bool $isSave
     * @return string
     */
    public function videoSnapshot($obj, string $process, bool $isSave = false)
    {
        $options = static::objectProcessOptions('video', '/snapshot,' . ($process ?: 't_7000,f_jpg,w_800,h_600,m_fast'));
        if (!$isSave) {
            return static::getSignUrl($obj, static::bucket(), static::$signUrlTimeout, OssClient::OSS_HTTP_GET, $options);
        } else {
            return static::processObject($obj, $options[OssClient::OSS_PROCESS]);
        }
    }

    /**
     * 下载对象
     *
     * @param $bucket
     * @param $object
     * @param $options
     * @return mixed
     */
    public function getObject($bucket, $object, $options = null)
    {
        return static::client()->getObject($bucket, $object, $options);
    }

    /**
     * 获取阿里云 STS OSS授权
     * STS授权依赖RAM用户，授权后客户端可直接用秘钥和token使用sdk，不用在依赖后端授权
     *
     * @return array
     */
    public function STSAuthorization(): array
    {
        $time = Carbon::createFromTimestamp(time())->format(\DateTime::ISO8601);
        $pos = strpos($time, '+');
        $time = substr($time, 0, $pos) . 'Z';
        $accessId = config('oss.access_key_id');
        $key = config('oss.access_key_secret');
        $stsHost = config('oss.sts_host');
        $policy = $this->STSPolicy(static::bucket());
        $params = [
            'Format'           => 'json', // json or xml
            'Version'          => '2015-04-01', // 固定值
            'SignatureMethod'  => 'HMAC-SHA1', // 固定值
            'SignatureNonce'   => Str::uuid()->getHex()->toString(),
            'SignatureVersion' => '1.0', // 固定值
            'AccessKeyId'      => $accessId,
            'Timestamp'        => $time, // ISO08601时间格式
            'Action'           => 'AssumeRole', // 固定值
            'RoleArn'          => config('oss.ram_arn'), // 对应aliyun的ram
            'RoleSessionName'  => 'fs-resource', // 自定义值
            'Policy'           => json_encode($policy), // 权限策略
            'DurationSeconds'  => static::$signUrlTimeout, // token有效期 min: 900, max: 3600
        ];
        $cont = 'POST&' . rawurlencode('/') . '&' . rawurlencode(OssUtil::toQueryString($params));
        $signature = base64_encode(hash_hmac('sha1', $cont, $key . '&', true));
        $params['Signature'] = $signature;
        $response = Http::asForm()->post($stsHost, $params);
        $data = $response->json();
        return [
            'SecurityToken'   => $data['SecurityToken'],
            'AccessKeyId'     => $data['AccessKeyId'],
            'AccessKeySecret' => $data['AccessKeySecret'],
            'Expiration'      => $data['Expiration'],
        ];
    }

    public function processObject($object, $process)
    {
        $bucket = static::bucket();
        $fileName = $this->objectName('image/jpeg', 'jpg');
        $process = $process . "|sys/saveas," .
            'o_' . $this->ossUrlEncode($fileName) . ',b_' . $this->ossUrlEncode($bucket);
        $res = static::client()->processObject($bucket, $object, $process);
        if ($res) {
            $response = json_decode($res, true);
            return [
                'object' => $response['object'] ?? '',
                'size'   => $response['fileSize'] ?? 0, // 字节
            ];
        } else {
            return false;
        }
    }
}
