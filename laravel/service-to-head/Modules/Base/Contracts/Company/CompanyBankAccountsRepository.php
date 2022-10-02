<?php


namespace Modules\Base\Contracts\Company;


interface CompanyBankAccountsRepository
{
    public function getAccountAndCompanyInfoByMethodAndCurrency(int $paymentMethodId, string $currency);

    public function getAccountInfoByMethodAndCurrency(int $paymentMethodId, string $currency, $uuid = '');

    public function updateAccountInfoById($uuid, $data);
}
