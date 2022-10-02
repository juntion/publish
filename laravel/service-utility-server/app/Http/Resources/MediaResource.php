<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'file_name' => $this->file_name,
            'mime_type' => $this->mime_type,
            'size'      => $this->size,
            'created_at' => $this->created_at->toDateTimeString(),
            'url'       => $this->getUrl(),
            'user_id'   => $this->user_id,
            'user_name' => $this->user_name,
        ];
    }
}
