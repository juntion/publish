<?php

namespace Modules\Share\Transformers\Categories;

use Modules\Base\Http\Resources\Json\ResourceCollection;
use Modules\Share\Transformers\Resource\ResourceCollectionResource;
use Modules\Share\Transformers\Resource\ResourceTagsResource;

class ResourceTagsCollection extends ResourceCollection
{

    public static $wrap = 'resources';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) use ($request) {
            return [
                'uuid'                           => $item->uuid,
                'creator_uuid'                   => $item->creator_uuid,
                'creator_name'                   => $item->creator_name,
                'custom_category_uuid'           => $item->custom_category_uuid,
                'type'                           => $item->type,
                'name'                           => $item->name,
                'size'                           => $item->size,
                'mime_type'                      => $item->mime_type,
                'format'                         => $item->format,
                'image_url_height_216_width_216' => $item->image_url_height_216_width_216,
                'duration'                       => $item->duration,
                'created_at'                     => $this->getZoneDatetime($item->created_at),
                'updated_at'                     => $this->getZoneDatetime($item->updated_at),
                'is_collection'                  => $item->collection->count(),
                'collection'                     => new ResourceCollectionResource($item->collection->first()),
                'tags'                           => $item->tags ? ResourceTagsResource::collection($item->tags) : [],
            ];
        })->all();
    }
}
