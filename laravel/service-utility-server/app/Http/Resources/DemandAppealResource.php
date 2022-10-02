<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class DemandAppealResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'number' => $this->number,
            'id'     => $this->id
        ];
    }

}
