<?php


namespace Modules\Base\Http\Resources\Company;


use Modules\Base\Http\Resources\Json\Resource;

class CompanyInfoResource extends Resource
{
    public function toArray($request)
    {
        return [
            'number'       => $this->number,
            'uuid'         => $this->uuid,
            'name'         => $this->name,
            'foreign_name' => $this->foreign_name,
            'simple_name'  => $this->simple_name,
            "type"         => $this->type,
            "contacts"     => $this->contacts,
            "profile"      => $this->profile,
            "status"       => $this->status,
            "address"      => $this->address ? new AddressResource($this->address) : null,
            'tax_info'     => $this->taxInfo ? TaxInfoResource::collection($this->taxInfo) : [],
            'media'        => $this->address ? MediaResource::collection($this->address->media) : [],
        ];
    }
}
