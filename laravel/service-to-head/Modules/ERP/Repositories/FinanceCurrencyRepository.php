<?php

namespace Modules\ERP\Repositories;

use Illuminate\Support\Carbon;
use Modules\ERP\Exceptions\FinanceCurrencyException;
use Modules\ERP\Entities\FinanceCurrency;
use Modules\ERP\Contracts\FinanceCurrencyRepository as ContractsFinanceCurrencyRepository;

class FinanceCurrencyRepository implements ContractsFinanceCurrencyRepository
{
    public function model()
    {
        return FinanceCurrency::class;
    }

    public function getExchangeRatesByTime($time)
    {
        return FinanceCurrency::select(['base_currency', 'source_currency', 'value'])
            ->where('limit_time', '=', $this->getExchangeRateTime($time))
            ->get();
    }

    public function getExchangeRate($time, $originCode, $aimCode)
    {
        return FinanceCurrency::select('value')
            ->where('limit_time', '=', $this->getExchangeRateTime($time))
            ->where('source_currency', '=', $originCode)
            ->where('base_currency', '=', $aimCode)
            ->limit(1)
            ->first();
    }

    private function getExchangeRateTime($time)
    {
        $date = Carbon::parse($time)->toDateString(); // 同一天的时间汇率一定一样，后台存的是datetime， 实际有效的是 date

        //获取有效的生效日期
        $limitTime = FinanceCurrency::select('limit_time')->where('limit_time', '<=', $date . ' 00:00:00')->orderBy('limit_time', 'desc')->limit(1)->pluck('limit_time')->first();
        if (!$limitTime) {
            throw new FinanceCurrencyException(__('erp::currency.unSupportTime', ['time' => $time]));
        }

        return $limitTime;
    }
}
