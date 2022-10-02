<?php


namespace Modules\Base\Http\Resources\Company;


use Modules\Base\Http\Resources\Json\Resource;

class OfficeOrWarehouseResource extends Resource
{
    public function toArray($request)
    {
        return [
            "uuid"                 => $this->uuid,
            "country_code"         => $this->country_code,
            "name"                 => $this->name,
            "country_name"         => $this->country_name,
            "province"             => $this->province,
            "city"                 => $this->city,
            "area"                 => $this->area,
            "address"              => $this->address,
            "foreign_name"         => $this->foreign_name,
            "foreign_country_name" => $this->foreign_country_name,
            "foreign_country_code" => $this->foreign_country_code,
            "foreign_province"     => $this->foreign_province,
            "foreign_city"         => $this->foreign_city,
            "foreign_area"         => $this->foreign_area,
            "foreign_address"      => $this->foreign_address,
            "postcode"             => $this->postcode,
            "foreign_postcode"     => $this->foreign_postcode,
            'comment'              => $this->comment,
            'status'               => $this->status,
            'contacts'             => $this->contacts ? ContactsResource::collection($this->contacts) : [],
            'foreign_contacts'     => $this->foreignContacts ? ContactsResource::collection($this->foreignContacts) : [],
            'media'                => $this->media ? MediaResource::collection($this->media) : [],
        ];
    }
}
