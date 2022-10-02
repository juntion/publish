<?php

namespace Modules\Share\Transformers\Resource;

use Modules\Base\Http\Resources\Json\Resource;

class ResourcesCategoriesTagsCollection extends Resource
{
    public static $wrap = 'resource';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid'                           => $this->uuid,
            'creator_uuid'                   => $this->creator_uuid,
            'creator_name'                   => $this->creator_name,
            'category_uuid'                  => $this->category_uuid,
            'custom_category_uuid'           => $this->custom_category_uuid,
            'type'                           => $this->type,
            'name'                           => $this->name,
            'size'                           => $this->size,
            'mime_type'                      => $this->mime_type,
            'duration'                       => $this->duration,
            'format'                         => $this->format,
            'image_url_height_500_width_930' => $this->image_url_height_500_width_930,
            'is_collection'                  => $this->collection->count(),
            'created_at'                     => $this->getZoneDatetime($this->created_at),
            'updated_at'                     => $this->getZoneDatetime($this->updated_at),
            'collection'                     => new ResourceCollectionResource($this->collection->first()),
            'categories'                     => $this->categories ? new ResourcesCategoriesCollection($this->categories()->orderBy('created_at', 'ASC')->first()): null,
            'tags'                           => $this->tags ? ResourceTagsResource::collection($this->tags) : [],
        ];
    }
}
