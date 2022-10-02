<?php

namespace Modules\Share\Transformers\Tag;

use Modules\Base\Http\Resources\Json\Resource;

class TagResource extends Resource
{
    public static $wrap = 'tag';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid'       => $this->uuid,
            'name'       => $this->name,
            'created_at' => $this->getZoneDatetime($this->created_at),
            // 'updated_at' => $this->getZoneDatetime($this->updated_at),
            'deleted_at' => $this->getZoneDatetime($this->deleted_at),
        ];
    }
}
