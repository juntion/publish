<?php


namespace Modules\Base\Http\Resources\Company;


use Modules\Base\Http\Resources\Json\ResourceCollection;

class CompanyInfoResourceCollection extends ResourceCollection
{
    public static $wrap = 'companies';

    public function toArray($request)
    {
        return $this->collection->map(function ($item){
            return [
                'number'       => $item->number,
                'uuid'         => $item->uuid,
                'name'         => $item->name,
                'foreign_name' => $item->foreign_name,
                'simple_name'  => $item->simple_name,
                "type"         => $item->type,
                "contacts"     => $item->contacts,
                "profile"      => $item->profile,
                "status"       => $item->status,
                "address"      => $item->address ? new AddressResource($item->address) : null,
                'tax_info'     => $item->taxInfo ? TaxInfoResource::collection($item->taxInfo) : [],
                'media'        => $item->address ? MediaResource::collection($item->address->media) : [],
            ];
        });
    }
}
