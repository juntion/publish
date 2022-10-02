<?php

namespace Modules\Finance\Http\Controllers\Currency;

use Modules\ERP\Contracts\FinanceCurrencyRepository;
use Modules\Finance\Http\Controllers\Controller;
use Modules\Finance\Http\Requests\Currency\SearchRequest;
use Modules\Finance\Http\Resources\Currency\Rates;

class CurrencyController extends Controller
{
    public function search(SearchRequest $request, FinanceCurrencyRepository $currencyRepository)
    {
        return new Rates($currencyRepository->getExchangeRatesByTime($request->input('time')));
    }
}
