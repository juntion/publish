<?php

namespace App\Http\Controllers;

use App\Models\System\Media;
use App\Support\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediasController extends Controller
{
    /**
     * @var UploadFile
     */
    private $uploadFile;

    /**
     * MediasController constructor.
     * @param UploadFile $uploadFile
     */
    public function __construct(UploadFile $uploadFile)
    {
        parent::__construct();

        $this->uploadFile = $uploadFile;
    }

    /**
     * 图片上传
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|file',
        ]);
        $file = $this->uploadFile->setFile($request->image);
        $fileName = Str::uuid()->getHex() . '.' . $file->getExtension();
        $path = $this->setFilePath($fileName);
        $file->setDiskName('images')
            ->setPath($path)
            ->setFileName($fileName)
            ->save(false);
        $image_url = $this->getImageUrl($path, $fileName);

        return $this->successWithData(compact('image_url'));
    }

    protected function getImageUrl($path, $fileName)
    {
        return config('app.url') . '/storage/images/' . $path . $fileName;
    }

    /**
     * @param $fileName
     * @return string
     */
    protected function setFilePath($fileName)
    {
        return substr($fileName, 0, 2) . '/' . substr($fileName, 2, 2) . '/';
    }

    /**
     * 删除媒体文件
     * @param Request $request
     * @param Media $media
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(Request $request, Media $media)
    {
        $request->validate([
            'file_name' => 'required|string',
        ]);
        if ($media->file_name != $request->file_name) {
            return $this->failedWithMessage('文件名错误!');
        }
        try {
            $disk = Storage::disk($media->disk);
            if ($disk->exists($media->getPath())) {
                $disk->delete($media->getPath());
            }
            $media->delete();
        } catch (\Exception $e) {
        }

        return $this->success();
    }

    /**
     * 下载文件(支持批量下载)
     * @param Request $request
     * @return string|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Request $request)
    {
        $request->validate([
            'media' => 'required|array',
            'media.*.id' => 'required|integer|exists:media,id',
            'media.*.file_name' => 'required|string',
        ]);

        // 单文件
        if (count($request->media) == 1) {
            $medias = Arr::first($request->media);
            $media = Media::find($medias['id']);
            if ($medias['file_name'] != $media->file_name) {
                return '文件名错误!';
            }
            if (file_exists($media->getPath())) {
                if (Str::contains($media->name, '/')) {
                    $media->name = Arr::last(explode('/', $media->name));
                }
                return response()->download($media->getPath(), $media->name);
            }
            return '文件不存在!';
        }

        // 多文件压缩成zip包
        $tmpDir = storage_path('app/tmp/') .
            date('Y-m-d') . '/' .
            Auth::id() . '/' .
            Str::uuid()->getHex();
        if (!is_dir($tmpDir)) {
            mkdir($tmpDir, 0777, true);
        }
        $nowFiles = [];
        $zipFileName = $tmpDir . '/' . date('YmdHis') . '.zip';
        $zip = new \ZipArchive();
        $zip->open($zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        foreach ($request->media as $item) {
            $media = Media::find($item['id']);
            if ($media->file_name != $item['file_name']) {
                continue;
            }
            if (!array_key_exists($sha1 = sha1(strtolower($media->name)), $nowFiles)) {
                $nowFiles[$sha1] = 0;
                $fileName = $media->name;
            } else {
                $nowFiles[$sha1]++;
                $pos = strrpos($media->name, '.');
                $fileName = substr($media->name, 0, $pos) .
                    "({$nowFiles[$sha1]})" .
                    substr($media->name, $pos);
            }
            $zip->addFile($media->getPath(), $fileName);
        }
        $zip->close();
        return response()->download($zipFileName);
    }
}
