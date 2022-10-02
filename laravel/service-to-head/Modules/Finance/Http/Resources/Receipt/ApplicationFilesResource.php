<?php


namespace Modules\Finance\Http\Resources\Receipt;


use Modules\Base\Http\Resources\Json\Resource;

class ApplicationFilesResource extends Resource
{
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'type' => $this->type,
        ];
    }
}
