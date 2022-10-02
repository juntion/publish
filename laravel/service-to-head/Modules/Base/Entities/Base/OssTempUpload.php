<?php

namespace Modules\Base\Entities\Base;

use Modules\Base\Database\Factories\OssTempUploadFactory;
use Modules\Base\Entities\Model;

class OssTempUpload extends Model
{
    protected $table = 'oss_temp_uploads';

    protected $fillable = [
        'uuid', 'object', 'bucket', 'origin_body'
    ];

    protected $casts = [
        'origin_body' => 'json'
    ];

    public static function newFactory()
    {
        return OssTempUploadFactory::new();
    }
}
