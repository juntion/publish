<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'created_at' => $this->created_at->toDateTimeString(),
            'user_name' => getUserNameById($this->causer_id),
            'description' => $this->description,
            'changes' => $this->properties->get('changes'),
        ];
    }
}
