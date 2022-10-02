<?php

namespace App\Models\System;

use App\Traits\DateFormatTrait;
use App\Traits\ModelsTrait;
use Spatie\MediaLibrary\Models\Media as MediaModel;

class Media extends MediaModel
{
    use ModelsTrait, DateFormatTrait;

    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return $this->getUrl();
    }

    public function toArray()
    {
        $data = parent::toArray();
        return [
            'id' => $data['id'],
            'name' => $data['name'],
            'file_name' => $data['file_name'],
            'mime_type' => $data['mime_type'],
            'size' => $data['size'],
            'created_at' => $data['created_at'],
            'url' => $data['url'],
            'user_id' => $data['user_id'],
            'user_name' => $data['user_name'],
            'collection_name' => $data['collection_name'],
        ];
    }
}
