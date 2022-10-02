<?php


namespace Modules\Share\Transformers\Admin\Collection;


use Modules\Base\Http\Resources\Json\Resource;
use Modules\Share\Transformers\Resource\ResourceTagsResource;

class CollectionResourceCollection extends Resource
{
    public function toArray($request)
    {
        return [
            'uuid'                           => $this->uuid,
            'creator_uuid'                   => $this->creator_uuid,
            'creator_name'                   => $this->creator_name,
            'custom_category_uuid'           => $this->custom_category_uuid,
            'type'                           => $this->type,
            'name'                           => $this->name,
            'size'                           => $this->size,
            'mime_type'                      => $this->mime_type,
            'format'                         => $this->format,
            'image_url_height_216_width_216' => $this->image_url_height_216_width_216,
            'duration'                       => $this->duration,
            'is_collection'                  => $this->collection->count(),
            'updated_at'                     => $this->getZoneDatetime($this->updated_at),
            'created_at'                     => $this->getZoneDatetime($this->created_at),
            'tags'                           => $this->tags ? ResourceTagsResource::collection($this->tags) : [],
        ];
    }
}
