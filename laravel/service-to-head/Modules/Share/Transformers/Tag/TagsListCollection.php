<?php

namespace Modules\Share\Transformers\Tag;

use Modules\Base\Http\Resources\Json\ResourceCollection;

class TagsListCollection extends ResourceCollection
{

    public static $wrap = 'tags';

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
                'uuid'       => $item->uuid,
                'name'       => $item->name,
                'deleted_at' => $this->getZoneDatetime($item->deleted_at),
                'created_at' => $this->getZoneDatetime($item->created_at),
            ];
        })->all();
    }
}
