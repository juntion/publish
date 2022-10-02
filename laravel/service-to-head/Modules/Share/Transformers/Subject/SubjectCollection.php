<?php

namespace Modules\Share\Transformers\Subject;

use Modules\Base\Http\Resources\Json\ResourceCollection;

class SubjectCollection extends ResourceCollection
{

    static public $wrap = 'subjects';

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
                'sort'       => $item->sort,
                'deleted_at' => $this->getZoneDatetime($item->deleted_at),
                'created_at' => $this->getZoneDatetime($item->created_at),
                'updated_at' => $this->getZoneDatetime($item->updated_at),
                'image_url'  => $item->image_url,
            ];
        })->all();
    }
}
