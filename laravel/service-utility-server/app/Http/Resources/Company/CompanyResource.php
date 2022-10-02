<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $emptyAddress = [
            'name'       => "",
            'en_name'    => "",
            'country'    => "",
            'province'   => "",
            'city'       => "",
            'area'       => "",
            'address'    => "",
            'en_country' => "",
            'en_province'=> "",
            'en_city'    => "",
            'en_area'    => "",
            'en_address' => "",
            'comment'    => "",
            'tel'        => "",
            'en_tel'     => ""
        ];
        $company['id'] = $this->id;
        $company['number'] = $this->number;
        $company['profile'] = $this->profile;
        $company['type'] = $this->type;
        $company['company_simple_name'] = $this->company_simple_name;
        $company['company_name'] = $this->company_name;
        $company['company_english_name'] = $this->company_english_name;
        $company['status'] = $this->status;
        $company['contacts'] = $this->contacts;
        $company['company_tax_info'] = CompanyTaxInfoResource::collection($this->taxInfo);
        $company['address'] = $this->address ? new CompanyAddressResource($this->address) : $emptyAddress;
        $company['media'] = $this->address ? MediaResource::collection($this->address->media) : [];

//        $office = CompanyOfficeResource::collection($this->office);
//
//        $warehouse = CompanyOfficeResource::collection($this->warehouse);
//
//        $bank = CompanyBankResource::collection($this->banks);
//        return compact('company','office','warehouse', 'bank');
        return $company;
    }
}
