<?php

namespace Modules\Share\Transformers\Categories;

use Modules\Base\Http\Resources\Json\ResourceCollection;
use Modules\Share\Transformers\Admin\Upload\UploadResourceCollection;

class MixListCollection extends ResourceCollection
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
                    'background'  => $item->background,
                    'created_at'  => $this->getZoneDatetime($item->created_at),
                    'updated_at'  => $this->getZoneDatetime($item->updated_at),
                    'deleted_at'  => $this->getZoneDatetime($item->deleted_at),
                ];
            } else {
                $resource = new UploadResourceCollection($item);
                return $resource;
            }
        })->all();
    }
}
