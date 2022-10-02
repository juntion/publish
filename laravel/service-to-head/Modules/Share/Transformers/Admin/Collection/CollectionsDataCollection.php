<?php


namespace Modules\Share\Transformers\Admin\Collection;


use Modules\Base\Http\Resources\Json\Resource;

class CollectionsDataCollection extends Resource
{
    public function toArray($request)
    {
        return [
            'data_type'     => 'collection',
            'uuid'          => $this->uuid,
            'resource_uuid' => $this->resource_uuid,
            'resource_name' => $this->resource_name,
            'category_uuid' => $this->category_uuid ?? "",
            'created_at'    => $this->getZoneDatetime($this->created_at),
            'resource'      => new CollectionResourceCollection($this->resources),
        ];
    }
}
