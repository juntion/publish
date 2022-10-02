<?php


namespace Modules\ERP\Contracts;


interface CurrencyService
{
    public static function getAllCurrencies();

    /**
     * $currency_id获取币种code
     * @param $currencies_id
     * @return mixed
     */
    public static function getCurrenciesCodeByID($currencies_id);
}
