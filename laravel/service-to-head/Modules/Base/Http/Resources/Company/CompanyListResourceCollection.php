<?php


namespace Modules\Base\Http\Resources\Company;


use Modules\Base\Http\Resources\Json\ResourceCollection;

class CompanyListResourceCollection extends ResourceCollection
{
    public static $wrap = 'companies';

    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                'number'       => $item->number,
                'uuid'         => $item->uuid,
                'id'           => $item->id,
                'name'         => $item->name,
                'foreign_name' => $item->foreign_name,
                'simple_name'  => $item->simple_name,
                "type"         => $item->type,
                "parent_uuid"  => $item->parent_uuid,
                "code"         => $item->code,
                "country_code" => $item->country_code,
                "country_name" => $item->country_name,
                "contacts"     => $item->contacts,
                "profile"      => $item->profile,
                "is_show"      => $item->is_show,
                "status"       => $item->status,
                "time_zone"    => $item->time_zone,
                "created_at"   => $item->created_at,
                "updated_at"   => $item->updated_at
            ];
        });
    }
}
