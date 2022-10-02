<?php


namespace Modules\ERP\Service;

use Modules\ERP\Contracts\CountryRepository;
use Modules\ERP\Contracts\CountryService as ContractsCountryService;

class CountrySearchService implements ContractsCountryService
{
    public static function getCountryList()
    {
        return app()->make(CountryRepository::class)->getCountryList();
    }

    public static function getCountryCodeByCountriesChineseName($name)
    {
        return app()->make(CountryRepository::class)->getCountryCodeByCountriesChineseName();
    }

    public static function getCountryCodeByCountriesName($name)
    {
        return app()->make(CountryRepository::class)->getCountryCodeByCountriesName();
    }

    public static function getCountryByFlag($countries_id)
    {
        return app()->make(CountryRepository::class)->getCountryByFlag($countries_id);
    }
}
