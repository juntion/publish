<?php

namespace Modules\Share\Transformers\Admin\Collection;


use Modules\Base\Http\Resources\Json\ResourceCollection;
use Modules\Share\Transformers\Admin\ViewedResourceCollection;

class DownloadedCollection extends ResourceCollection
{
    public static $wrap = 'downloads';

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
