<?php

namespace App\Support;

use App\Traits\ResponseTrait;
use Illuminate\Http\UploadedFile;

class Upload
{
    /**
     * @param array $files
     * @return \Illuminate\Support\Collection
     * @author: King
     * @version: 2019/4/18 19:03
     */
    public static function addMultipleFiles(array $files)
    {
        return app(UploadFileFactory::class)->createMultipleUploadFile($files);
    }

    /**
     * @param UploadedFile $file
     * @return UploadFile
     * @author: King
     * @version: 2019/4/18 19:04
     */
    public static function addFile(UploadedFile $file)
    {
        return app(UploadFile::class)->setFile($file)->verify();
    }
}