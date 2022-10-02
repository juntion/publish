<?php

namespace App\Support;

use App\Exceptions\System\InvalidParameterException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadFile
{
    /**
     * @var UploadedFile
     */
    protected $file;

    protected $pathName;
    protected $diskName;
    protected $fileName;
    protected $name;
    protected $extension;
    protected $savePath;

    /**
     * @param UploadedFile $file
     * @return $this
     * @author King
     * @version 2019/4/17 17:44
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        $this->fileName = $this->file->getClientOriginalName();
        $this->extension = strtolower(pathinfo($this->fileName,PATHINFO_EXTENSION) !== '' ? pathinfo($this->fileName,PATHINFO_EXTENSION) : $this->file->getClientMimeType());
        $this->name = $this->fileName;
        $this->pathName = now()->toDateString();
        $this->diskName = 'tmp';
        return $this;
    }

    /**
     * @return $this
     * @throws InvalidParameterException
     * @author: King
     * @version: 2019/5/24 12:05
     */
    public function verify()
    {
        if (!in_array($this->extension, config('app.allow_extension'))) {
            throw new InvalidParameterException(__('error.file_type_error'));
        }
        return $this;
    }

    /**
     * @param string $pathName
     * @return $this
     * @author: King
     * @version: 2019/4/18 18:04
     */
    public function setPath(string $pathName)
    {
        $this->pathName = str_replace('.', '/', $pathName);
        return $this;
    }

    /**
     * @param string $diskName
     * @return $this
     * @author: King
     * @version: 2019/4/18 18:04
     */
    public function setDiskName(string $diskName)
    {
        $this->diskName = $diskName;
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     * @author: King
     * @version: 2019/4/18 17:51
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $fileName
     * @return $this
     * @author: King
     * @version: 2019/4/18 17:53
     */
    public function setFileName(string $fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @param bool $hex
     * @return UploadInfo|bool
     * @throws InvalidParameterException
     * @author: King
     * @version: 2019/5/28 11:34
     */
    public function save($hex = true)
    {
        $this->verify();
        $this->fileName = $hex ? Str::uuid()->getHex() : $this->fileName;
        $this->savePath = Storage::disk($this->diskName)->putFileAs($this->pathName, $this->file, $this->fileName);
        $uploadInfo = new UploadInfo($this);

        return $this->savePath ? $uploadInfo : false;
    }

    /**
     * @return mixed
     */
    public function getDiskName()
    {
        return $this->diskName;
    }

    /**
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPathName()
    {
        return $this->pathName;
    }

    /**
     * @return UploadedFile
     */
    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    /**
     * @return mixed
     */
    public function getSavePath()
    {
        return $this->savePath;
    }
}
