<?php

namespace Modules\Share\Transformers\Resource;

use Modules\Base\Http\Resources\Json\Resource;

class ResourceCollectionResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "uuid"          => $this->uuid,
            "resource_uuid" => $this->resource_uuid,
            "category_uuid" => $this->category_uuid,
            "created_at"    => $this->getZoneDatetime($this->created_at),
        ];
    }
}
