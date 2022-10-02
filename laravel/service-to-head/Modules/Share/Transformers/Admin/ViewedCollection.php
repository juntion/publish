<?php

namespace Modules\Share\Transformers\Admin;


use Modules\Base\Http\Resources\Json\ResourceCollection;

class ViewedCollection extends ResourceCollection
{

    public static $wrap = 'vieweds';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                'uuid'          => $item->uuid,
                'created_at'    => $this->getZoneDatetime($item->created_at),
                'resource_name' => $item->resource_name,
                'resource'      => $item->resource ? new ViewedResourceCollection($item->resource) : null,
            ];
        })->all();
    }
}
