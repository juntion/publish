<?php

namespace Modules\Share\Transformers\Resource;

use Modules\Base\Http\Resources\Json\Resource;

class ResourcesCategoriesCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $categories = [];
        $level = $this->level;
        $parent = $this;
        for ($i = $level; $i >= 1; $i--) {
            $parent = $i == $level ? $this : $parent->parent;
            array_unshift($categories, $this->transformer($parent));
        }
        return $categories;
    }

    private function transformer($build)
    {
        return [
            'uuid'        => $build->uuid,
            'type'        => $build->type,
            'parent_uuid' => $build->parent_uuid,
            'name'        => $build->name,
            'background'  => $build->background,
            'sort'        => $build->sort,
            'sum'         => $build->sum,
            'created_at'  => $this->getZoneDatetime($build->created_at),
            'updated_at'  => $this->getZoneDatetime($build->updated_at),
        ];
    }
}
