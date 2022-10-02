<?php


namespace App\Services\Common\Upload;

use Upload\Validation\Size as S;

class Size extends S
{
    public static $maxSizeMessage;

    public function __construct($maxSizeMessage = "")
    {
        self::$maxSizeMessage = defined("FS_UPLOAD_NEW_NOTICE_FOUR") ?
            FS_UPLOAD_NEW_NOTICE_FOUR : 'Maximum size 300KB.';
        parent::__construct($maxSizeMessage);
    }

    public function validate(\Upload\File $file)
    {
        $fileSize = $file->getSize();
        $isValid = true;

        if ($fileSize < $this->minSize) {
            $this->setMessage('File size is too small');
            $isValid = false;
        }
        if ($fileSize > $this->maxSize) {
            $this->setMessage(self::$maxSizeMessage);
            $isValid = false;
        }

        return $isValid;
    }
}
