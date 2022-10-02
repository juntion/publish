<?php


namespace Modules\UUMS\Entities;

use Illuminate\Support\Str;

class CompanyPay extends Model
{
    protected $table = "company_pay";

    public function company()
    {
        return $this->belongsTo(Company::class, "id", "company_id");
    }

    public function export(): array
    {
        return [
            'id'    => $this->id,
            'uuid'  => Str::uuid()->getHex()->toString(),
            'company_id' => $this->company_id,
            'bank_name'  => $this->bank_name,
            'account_name' => $this->account_name,
            'check_address' => $this->check_address ?? "",
            'other_info'     => $this->other_info,
            'comment'              => $this->comment ?? "",
            'status'               => $this->status,
            'created_at'           => $this->created_at,
            'updated_at'           => $this->updated_at,
        ];
    }
}
