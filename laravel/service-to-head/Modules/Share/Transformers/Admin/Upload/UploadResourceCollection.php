<?php

namespace Modules\Share\Transformers\Admin\Upload;

use Modules\Base\Http\Resources\Json\Resource;
use Modules\Share\Transformers\Resource\ResourceCollectionResource;
use Modules\Share\Transformers\Resource\ResourceTagsResource;

class UploadResourceCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data_type'                      => 'resource',
            'uuid'                           => $this->uuid,
            'creator_uuid'                   => $this->creator_uuid,
            'creator_name'                   => $this->creator_name,
            'custom_category_uuid'           => $this->custom_category_uuid,
            'type'                           => $this->type,
            'name'                           => $this->name,
            'size'                           => $this->size,
            'mime_type'                      => $this->mime_type,
            'duration'                       => $this->duration,
            'format'                         => $this->format,
            'image_url_height_216_width_216' => $this->image_url_height_216_width_216,
            'created_at'                     => $this->getZoneDatetime($this->created_at),
            'updated_at'                     => $this->getZoneDatetime($this->updated_at),
            'is_collection'                  => $this->collection->count(),
            'collection'                     => new ResourceCollectionResource($this->collection->first()),
            'tags'                           => $this->tags ? ResourceTagsResource::collection($this->tags) : [],
        ];
    }
}
