<?php


namespace Modules\ERP\Contracts;


interface CountryService
{
    public static function getCountryList();

    public static function getCountryCodeByCountriesChineseName($name);

    public static function getCountryCodeByCountriesName($name);

    public static function getCountryByFlag($country_id);
}
