<?php


namespace Modules\Base\Http\Controllers\Country;


use Modules\Base\Http\Controllers\Controller;
use Modules\ERP\Contracts\CountryService;

class CountryController extends Controller
{
    public function all(CountryService $countryService)
    {
        $data = collect($countryService->getCountryList())->map(function ($item) {
            return [
                'zh'   => $item['countries_chinese_name'],
                'en'   => $item['countries_name'],
                'code' => $item['countries_iso_code_2'],
            ];
        });
        return $this->successWithData($data);
    }
}
