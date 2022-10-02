<?php


namespace Modules\Base\Http\Resources\Company;


use Modules\Base\Http\Resources\Json\Resource;

class TaxInfoResource extends Resource
{
    public function toArray($request)
    {
        return [
            "uuid"         => $this->uuid,
            "country_code" => $this->country_code,
            "country_name" => $this->country_name,
            "tax_number"   => $this->tax_number,
        ];
    }
}
