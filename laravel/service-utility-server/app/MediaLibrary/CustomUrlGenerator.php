<?php
/**
 * Created by PhpStorm.
 * User: King
 * Date: 2020/4/22
 * Time: 22:34
 */

namespace App\MediaLibrary;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Filesystem\FilesystemManager;
use Spatie\MediaLibrary\UrlGenerator\BaseUrlGenerator;

class CustomUrlGenerator extends BaseUrlGenerator
{
    /** @var \Illuminate\Filesystem\FilesystemManager */
    protected $filesystemManager;

    public function __construct(Config $config, FilesystemManager $filesystemManager)
    {
        $this->filesystemManager = $filesystemManager;

        parent::__construct($config);
    }

    /**
     * Get the url for the profile of a media item.
     *
     * @return string
     */
    public function getUrl() : string
    {
        return $this->getBaseUrl() . '/' . $this->getPathRelativeToRoot();
    }

    /**
     * Get the temporary url for a media item.
     *
     * @param \DateTimeInterface $expiration
     * @param array $options
     *
     * @return string
     */
    public function getTemporaryUrl(\DateTimeInterface $expiration, array $options = []): string
    {
        return $this
            ->filesystemManager
            ->disk($this->media->disk)
            ->temporaryUrl($this->getPath(), $expiration, $options);
    }

    /**
     * @return string
     * @author: King
     * @version: 2020/4/23 11:07
     */
    public function getPath(): string
    {
        return $this->getStoragePath().'/'.$this->getPathRelativeToRoot();
    }

    /**
     * @return string
     * @author: King
     * @version: 2020/4/23 11:07
     */
    protected function getStoragePath() : string
    {
        $diskRootPath = $this->config->get("filesystems.disks.{$this->media->disk}.root");

        return realpath($diskRootPath);
    }

    /**
     * Get the url to the directory containing responsive images.
     *
     * @return string
     */
    public function getResponsiveImagesDirectoryUrl(): string
    {
        return $this->getBaseUrl() . '/' . $this->pathGenerator->getPathForResponsiveImages($this->media);
    }

    /**
     * @return mixed
     * @author: King
     * @version: 2020/4/23 10:32
     */
    public function getBaseUrl()
    {
        return $this->config->get("filesystems.disks.{$this->media->disk}.url");
    }
}