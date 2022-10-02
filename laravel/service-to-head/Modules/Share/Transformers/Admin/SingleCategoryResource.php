<?php


namespace Modules\Share\Transformers\Admin;


use Modules\Base\Http\Resources\Json\Resource;

class SingleCategoryResource extends Resource
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
            'name'        => $this->name,
            'sort'        => $this->sort,
            'sum'         => $this->sum,
            'created_at'  => $this->getZoneDatetime($this->created_at),
            'updated_at'  => $this->getZoneDatetime($this->updated_at),
        ];
    }
}
