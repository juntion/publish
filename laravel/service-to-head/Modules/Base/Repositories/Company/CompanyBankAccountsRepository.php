<?php


namespace Modules\Base\Repositories\Company;

use Modules\Base\Contracts\Company\CompanyBankAccountsRepository as ContractsCompanyBankAccountsRepository;
use Modules\Base\Entities\Company\CompanyBankAccount;

class CompanyBankAccountsRepository implements ContractsCompanyBankAccountsRepository
{
    public function getAccountAndCompanyInfoByMethodAndCurrency(int $paymentMethodId, string $currency)
    {
        return CompanyBankAccount::query()
            ->where('payment_method_id', $paymentMethodId)
            ->where('currency_code', $currency)
            ->with('company')
            ->first();
    }

    public function getAccountInfoByMethodAndCurrency(int $paymentMethodId, string $currency, $uuid = '')
    {
        return CompanyBankAccount::query()
            ->where('payment_method_id', $paymentMethodId)
            ->where('currency_code', $currency)
            ->when(($uuid != ''), function ($q)use($uuid) {
                $q->where('uuid', '!=', $uuid);
            })
            ->first();
    }

    public function updateAccountInfoById($uuid, $data)
    {
        CompanyBankAccount::query()->find($uuid)->update($data);
    }
}
