<?php


namespace Modules\Base\Http\Resources\Company;


use Modules\Base\Http\Resources\Json\Resource;

class TypeCompanyResource extends Resource
{
    public function toArray($request)
    {
        return [
            'uuid'   => $this->uuid,
            'name'   => $this->name,
            'status' => $this->status,
            'type'   => $this->type,
        ];
    }
}
