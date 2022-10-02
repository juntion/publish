<?php

namespace App\Traits;

use App\Models\System\Media;
use App\Support\Upload;
use App\Support\UploadInfo;
use Illuminate\Support\Facades\Storage;

trait ModelsTrait
{
    /**
     * 获取数据表名称，并设置别名
     * @param $alias
     * @return string
     * @author King
     * @version 2019/3/8 13:27
     */
    public function alias($alias)
    {
        return $this->getTable() . ' as ' . $alias;
    }

    /**
     * @param $collectionName
     * @param $pathInfo
     * @param bool $ext
     * @return Media
     * @author: King
     * @version: 2019/5/28 12:27
     */
    public function moveTmpMedia($collectionName, $pathInfo, $ext = false)
    {
        $uploadInfo = new UploadInfo($pathInfo);
        return $this->addMedia(storage_path('app/' . $uploadInfo->path))
            ->usingName($uploadInfo->originName)
            ->usingFileName($ext ? $uploadInfo->extFilename : $uploadInfo->filename)
            ->toMediaCollection($collectionName);
    }

    /**
     * 添加附件
     * @param $medias
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function addMedias($medias)
    {
        if (!is_array($medias)) {
            $medias = func_get_args();
        }
        foreach ($medias as $media) {
            $path = Upload::addFile($media)->save();
            $this->moveTmpMedia($this->getMediaCollectionName(), $path, true);
        }
    }

    /**
     * 清除附件
     */
    public function clearMedias()
    {
        $medias = $this->media()->get();
        $medias->each(function (Media $media) {
            try {
                if (Storage::disk($media->disk)->exists($media->getPath())) {
                    Storage::disk($media->disk)->delete($media->getPath());
                }
                $media->delete();
            } catch (\Exception $e) {
            }
        });
    }
}
