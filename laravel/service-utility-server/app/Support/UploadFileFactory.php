<?php

namespace App\Support;


use Illuminate\Http\UploadedFile;

class UploadFileFactory
{
    /**
     * @param UploadedFile $file
     * @return mixed
     * @author: King
     * @version: 2019/4/18 18:57
     */
    public function create(UploadedFile $file)
    {
        return app(UploadFile::class)->setFile($file)->verify();
    }

    /**
     * @param array $files
     * @return \Illuminate\Support\Collection
     * @author: King
     * @version: 2019/4/18 19:01
     */
    public function createMultipleUploadFile(array $files)
    {
        return collect($files)
            ->map(function ($file) {
                return $this->create($file);
            })
            ->flatten();
    }
}