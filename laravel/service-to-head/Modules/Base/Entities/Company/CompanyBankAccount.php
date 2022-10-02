<?php


namespace Modules\Base\Entities\Company;


use Modules\Base\Entities\Model;

class CompanyBankAccount extends Model
{
    protected $table = "company_bank_accounts";

    protected $fillable = ['company_bank_uuid', 'account_number', 'currency_code', 'other_info', 'uuid', 'created_at', 'updated_at', 'payment_method_id', 'payment_method_name'];

    public function company()
    {
        return $this->hasOneThrough(Company::class, CompanyBank::class, 'uuid', 'uuid', 'company_bank_uuid', 'company_uuid');
    }
}
