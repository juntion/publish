<?php


namespace Modules\Base\Http\Controllers\Currency;


use Modules\Base\Http\Controllers\Controller;
use Modules\ERP\Contracts\CurrencyService;

class CurrencyController extends Controller
{
   public function all(CurrencyService $currencyService)
   {
       $currencies = $currencyService->getAllCurrencies();
       return $this->successWithData(compact('currencies'));
   }
}
