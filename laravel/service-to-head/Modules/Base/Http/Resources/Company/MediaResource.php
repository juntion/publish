<?php


namespace Modules\Base\Http\Resources\Company;

use Modules\Base\Http\Resources\Json\Resource;

class MediaResource extends Resource
{
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'size' => $this->size,
        ];
    }
}
