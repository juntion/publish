<?php

namespace Modules\Share\Transformers\Categories;

use Modules\Base\Http\Resources\Json\Resource;

class CategoryResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid'        => $this->uuid,
            'type'        => $this->type,
            'parent_uuid' => $this->parent_uuid,
            'level'       => $this->level,
            'name'        => $this->name,
            'background'  => $this->background,
            'sort'        => $this->sort,
            'sum'         => $this->sum,
            'created_at'  => $this->getZoneDatetime($this->created_at),
            'updated_at'  => $this->getZoneDatetime($this->updated_at),
            'deleted_at'  => $this->getZoneDatetime($this->deleted_at),
        ];
    }
}
