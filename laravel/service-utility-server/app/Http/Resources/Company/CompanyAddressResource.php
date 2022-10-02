<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = $this->only(['name', 'en_name', 'country', 'province', 'city','area', 'address', 'en_country', 'en_province', 'en_city', 'en_area', 'en_address', 'comment']);
        $data['tel'] = $this->tel;
        $data['en_tel'] = $this->en_tel;
        return $data;
    }
}
