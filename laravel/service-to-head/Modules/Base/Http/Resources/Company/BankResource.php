<?php


namespace Modules\Base\Http\Resources\Company;


use Modules\Base\Http\Resources\Json\Resource;

class BankResource extends Resource
{
    public function toArray($request)
    {
        return [
            'uuid'          => $this->uuid,
            'bank_name'     => $this->bank_name,
            'account_name'  => $this->account_name,
            'check_address' => $this->check_address,
            'status'        => $this->status,
            'comment'       => $this->comment,
            'other_info'    => $this->other_info,
            'media'         => $this->media ? MediaResource::collection($this->media) : [],
            'account_info'  => $this->bankAccount ? AccountInfoResource::collection($this->bankAccount) : [],
        ];
    }
}
