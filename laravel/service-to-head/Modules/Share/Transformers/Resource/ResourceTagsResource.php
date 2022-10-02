<?php

namespace Modules\Share\Transformers\Resource;


use Modules\Base\Http\Resources\Json\Resource;

class ResourceTagsResource extends Resource
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
            'uuid'       => $this->uuid,
            'name'       => $this->name,
            'admin_uuid' => $this->pivot->admin_uuid,
            'created_at' => $this->getZoneDatetime($this->created_at)
        ];
    }
}
