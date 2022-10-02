<?php


namespace Modules\ERP\Repositories;


use Modules\ERP\Contracts\CurrencyRepository as ContractsCurrencyRepository;
use Modules\ERP\Entities\Currency;
use Prettus\Repository\Eloquent\BaseRepository;

class CurrencyRepository extends BaseRepository implements ContractsCurrencyRepository
{
    public function model()
    {
        return Currency::class;
    }

    public static function getAllCurrencies()
    {
        return Currency::query()->select('code')->get()->toArray();
    }

    /**
     * $currency_id获取币种code
     * @param $currencies_id
     * @return mixed
     */
    public static function getCurrenciesCodeByID($currencies_id)
    {
        return Currency::query()->select('code')->where('currencies_id',$currencies_id)->first()->toArray();
    }

    /**
     * $currency_id获取币种code
     * @param string $code
     * @return mixed
     */
    public static function getCurrenciesIdByCode(string $code)
    {
        return Currency::query()->where('code', $code)->first()->toArray();
    }

    public static function getServiceFormatByErp($amount)
    {
       return intval(round($amount * 100));
    }
}
