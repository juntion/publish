<?php


namespace Modules\Share\Transformers\Categories;


use Modules\Base\Http\Resources\Json\Resource;

class MixCategoryDataCollection extends Resource
{
    public function toArray($request)
    {
        return [
            'data_type'   => 'category',
            'uuid'        => $this->uuid,
            'type'        => $this->type,
            'parent_uuid' => $this->parent_uuid,
            'name'        => $this->name,
            'sort'        => $this->sort,
            'sum'         => $this->sum,
            'background'  => $this->background,
            'created_at'  => $this->getZoneDatetime($this->created_at),
            'updated_at'  => $this->getZoneDatetime($this->updated_at),
            'deleted_at'  => $this->getZoneDatetime($this->deleted_at),
        ];
    }
}
