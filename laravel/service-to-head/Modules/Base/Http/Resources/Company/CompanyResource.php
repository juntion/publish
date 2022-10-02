<?php


namespace Modules\Base\Http\Resources\Company;


use Modules\Base\Http\Resources\Json\Resource;

class CompanyResource extends Resource
{
    public function toArray($request)
    {
       return [
           'number'       => $this->number,
           'uuid'         => $this->uuid,
           'id'           => $this->id,
           'name'         => $this->name,
           'foreign_name' => $this->foreign_name,
           'simple_name'  => $this->simple_name,
           "type"         => $this->type,
           "parent_uuid"  => $this->parent_uuid,
           "code"         => $this->code,
           "country_code" => $this->country_code,
           "country_name" => $this->country_name,
           "contacts"     => $this->contacts,
           "profile"      => $this->profile,
           "is_show"      => $this->is_show,
           "status"       => $this->status,
           "time_zone"    => $this->time_zone,
           "created_at"   => $this->created_at,
           "updated_at"   => $this->updated_at
       ];
    }
}
