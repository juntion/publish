<?php


namespace Modules\Base\Http\Resources\Company;


use Modules\Base\Http\Resources\Json\Resource;

class AddressResource extends Resource
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
            "comment"              => $this->comment,
            "tel"                  => $this->tel,
            'foreign_tel'          => $this->foreign_tel,
        ];
    }
}
