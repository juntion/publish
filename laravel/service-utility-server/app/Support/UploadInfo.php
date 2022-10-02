<?php

namespace App\Support;

use Illuminate\Support\Collection;

class UploadInfo
{
    public $originName;
    public $filename;
    public $extension;
    public $extFilename;
    public $path;
    public $basePath;
    public $disk;
    public $dir;

    /**
     * UploadInfo constructor.
     * @param $pathInfo
     */
    public function __construct($pathInfo)
    {
        if ($pathInfo instanceof UploadFile){
            $this->originName = $pathInfo->getName();
            $this->filename = $pathInfo->getFileName();
            $this->extension = $pathInfo->getExtension();
            if($pathInfo->getExtension() == "image/jpeg") {
                $this->extension = 'jpg';
            }
            $this->extFilename = $this->filename . '.' . $this->extension;
            $this->disk = $pathInfo->getDiskName();
            $this->dir = $pathInfo->getPathName();
            $this->basePath = $this->disk . '/' . $this->dir;
            $this->path = $this->basePath . '/' . $this->filename;
        }else{
            if (!$pathInfo instanceof Collection){
                $pathInfo = collect($pathInfo);
            }
            $this->originName = $pathInfo->get('originName');
            $this->filename = $pathInfo->get('filename');
            $this->extension = $pathInfo->get('extension');
            $this->extFilename = $pathInfo->get('extFilename');
            $this->disk = $pathInfo->get('disk');
            $this->dir = $pathInfo->get('dir');
            $this->basePath = $pathInfo->get('basePath');
            $this->path = $pathInfo->get('path');
        }
    }
}
