<?php

namespace Modules\ERP\Service;

use Illuminate\Support\Carbon;
use Modules\ERP\Exceptions\FinanceCurrencyException;
use Modules\ERP\Contracts\FinanceExchangeRateService as ContractsFinanceExchangeRateService;
use Modules\ERP\Contracts\FinanceCurrencyRepository;

class FinanceExchangeRateService implements ContractsFinanceExchangeRateService
{
    private $currencyRepository;
    private $rates;

    public function __construct(FinanceCurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function rate($time, $originCode, $aimCode): float
    {
        $date = Carbon::parse($time)->toDateString(); // 同一天的时间汇率一定一样，后台存的是datetime， 实际有效的是 date

        if (isset($this->rates[$date . $originCode . $aimCode])) {
            return $this->rates[$date . $originCode . $aimCode];
        }

        $exchangeRate = $this->currencyRepository->getExchangeRate($time, $originCode, $aimCode);
        if (!$exchangeRate) {
            throw new FinanceCurrencyException(__('erp::currency.unSupportRate', ['time' => $time, 'originCode' => $originCode, 'aimCode' => $aimCode]));
        }

        return $this->rates[$date . $originCode . $aimCode] = $exchangeRate->value;
    }

    public function exchange($time, $originCode, int $originAmount, $aimCode): int
    {
        return round($this->rate($time, $originCode, $aimCode) * $originAmount);
    }
}
