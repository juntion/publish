<?php

namespace Modules\Share\Transformers\Admin\Collection;

use Modules\Base\Http\Resources\Json\ResourceCollection;

class CategoriesMixResourceCollection extends ResourceCollection
{
    public static $wrap = 'mixs';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            if ($item->data_type == 'category') {
                return [
                    'data_type'   => 'category',
                    'uuid'        => $item->uuid,
                    'type'        => $item->type,
                    'parent_uuid' => $item->parent_uuid,
                    'name'        => $item->name,
                    'sort'        => $item->sort,
                    'sum'         => $item->sum,
                    'created_at'  => $this->getZoneDatetime($item->created_at),
                    'updated_at'  => $this->getZoneDatetime($item->updated_at),
                ];
            } else {
                return [
                    'data_type'     => 'collection',
                    'uuid'          => $item->uuid,
                    'resource_uuid' => $item->resource_uuid,
                    'resource_name' => $item->resource_name,
                    'category_uuid' => $item->category_uuid ?? "",
                    'created_at'    => $this->getZoneDatetime($item->created_at),
                    'resource'      => new CollectionResourceCollection($item->resource),
                ];
            }
        })->all();
    }
}
