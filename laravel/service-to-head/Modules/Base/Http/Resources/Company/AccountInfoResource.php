<?php


namespace Modules\Base\Http\Resources\Company;


use Modules\Base\Http\Resources\Json\Resource;

class AccountInfoResource extends Resource
{
    public function toArray($request)
    {
        return [
            'uuid'                => $this->uuid,
            'account_number'      => $this->account_number,
            'currency_code'       => $this->currency_code,
            'other_info'          => $this->other_info,
            'payment_method_id'   => $this->payment_method_id,
            'payment_method_name' => $this->payment_method_name,
        ];
    }
}
