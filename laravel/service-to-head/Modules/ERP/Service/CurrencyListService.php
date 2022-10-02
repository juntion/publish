<?php


namespace Modules\ERP\Service;


use Illuminate\Contracts\Container\BindingResolutionException;
use Modules\ERP\Contracts\CurrencyRepository;
use Modules\ERP\Contracts\CurrencyService;

class CurrencyListService implements CurrencyService
{
    public static function getAllCurrencies()
    {
        return app()->make(CurrencyRepository::class)->getAllCurrencies();
    }

    /**
     * $currency_id获取币种code
     * @param $currencies_id
     * @return mixed
     * @throws BindingResolutionException
     */
    public static function getCurrenciesCodeByID($currencies_id)
    {
        return app()->make(CurrencyRepository::class)->getCurrenciesCodeByID($currencies_id);
    }
}
