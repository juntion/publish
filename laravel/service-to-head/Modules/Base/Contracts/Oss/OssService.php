<?php

namespace Modules\Base\Contracts\Oss;


interface OssService
{

    /**
     * 获取bucket名称
     *
     * @return string
     */
    public function bucket(): string ;

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
    public function getSignUrl($obj, $bucket, $timeout, $method, $options): string ;

    /**
     * 返回签名信息用于前端post上传
     *
     * @param array $options
     * @return array
     */
    public function webUploadPolicy(array $options): array ;

    /**
     * 删除多个object
     *
     * @param $bucket
     * @param array $objects
     * @param null|array $options
     * @return mixed
     */
    public function deleteObjects($bucket, array $objects, $options);

    /**
     * 删除指定单个object
     *
     * @param $bucket
     * @param $object
     * @param null|array $options
     * @return mixed
     */
    public function deleteObject($bucket, $object, $options);

    /**
     * 返回带有签名的指定缩略图url
     *
     * @param $obj
     * @param string $process
     * @param bool $isSave
     * @return string
     */
    public function imageResize($obj, string $process, bool $isSave);

    /**
     *  返回带有签名的指定水印图url
     *
     * @param $obj
     * @param $base64Image
     * @param string $process
     * @param bool $isSave
     * @return string
     */
    public function imageWatermark($obj, $base64Image, string $process, bool $isSave): string ;

    /**
     * 视频截帧
     *
     * @param $obj
     * @param string $process
     * @param bool $isSave
     * @return string
     */
    public function videoSnapshot($obj, string $process,  bool $isSave);

    /**
     * 下载对象
     *
     * @param $bucket
     * @param $object
     * @param $options
     * @return mixed
     */
    public function getObject($bucket, $object, $options);

    /**
     * 获取STS token授权信息
     *
     * @return array
     */
    public function STSAuthorization(): array ;
}
