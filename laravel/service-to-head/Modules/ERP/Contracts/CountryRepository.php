<?php


namespace Modules\ERP\Contracts;


use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;

interface CountryRepository extends RepositoryInterface,RepositoryCriteriaInterface
{
    public static function getCountryList();

    public static function getCountryCodeByCountriesChineseName($name);

    public static function getCountryCodeByCountriesName($name);

    public static function getCountryByFlag($countries_id);
}
