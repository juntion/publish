<?php


namespace Modules\UUMS\Entities;


use Illuminate\Support\Str;

class CompanyPayAccountInfo extends Model
{
    protected $table = "company_pay_account_info";


    public function export(): array
    {
        return [
            'id'    => $this->id,
            'uuid'  => Str::uuid()->getHex()->toString(),
            'currency_code' => $this->currency,
            'account_number' => $this->account_number,
            'other_info'     => $this->other_info,
            'pay_id'         => $this->pay_id,
        ];
    }
}
