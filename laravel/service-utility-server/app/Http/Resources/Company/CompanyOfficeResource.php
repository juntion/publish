<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyOfficeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        $data = $this->only(['id','name', 'en_name', 'country', 'province', 'city','area', 'address', 'en_country', 'en_province', 'en_city', 'en_area', 'en_address']);
        $data['comment'] = $this->comment ?? "";
        $data['postcode'] = $this->postcode;
        $data['en_postcode'] = $this->en_postcode;
        $data['status'] = $this->status;
        $data['cn_status'] = $this->cn_status;
        $data['contacts'] = CompanyContactsResource::collection($this->contacts->where('type', 1));
        $data['en_contacts'] = CompanyContactsResource::collection($this->contacts->where('type', 2));
        $data['media'] = MediaResource::collection($this->media);
        return $data;
    }
}
