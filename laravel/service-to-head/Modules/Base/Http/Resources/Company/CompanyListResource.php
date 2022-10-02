<?php


namespace Modules\Base\Http\Resources\Company;


use Modules\Base\Http\Resources\Json\Resource;

class CompanyListResource extends Resource
{
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'code' => $this->code
        ];
    }
}
