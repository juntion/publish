<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyBankResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = $this->only(['id', 'pay_method', 'check_address', 'status', 'cn_status', 'comment', 'bank_name', 'account_name', 'other_info']);
        $data['media'] = MediaResource::collection($this->media);
        $data['account_info'] = CompanyPayAccountInfoResource::collection($this->accountInfos);
        return $data;
    }
}
