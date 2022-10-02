<?php


namespace Modules\ERP\Contracts;


use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

interface CurrencyRepository extends RepositoryInterface,RepositoryCriteriaInterface
{
    public static function getAllCurrencies();

    /**
     * $currency_id获取币种code
     * @param $currencies_id
     * @return mixed
     */
    public static function getCurrenciesCodeByID($currencies_id);

    public static function getCurrenciesIdByCode(string $code);

    public static function getServiceFormatByErp($amount);
}
