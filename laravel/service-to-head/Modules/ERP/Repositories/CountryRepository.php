<?php


namespace Modules\ERP\Repositories;


use Modules\ERP\Entities\Country;
use Prettus\Repository\Eloquent\BaseRepository;
use Modules\ERP\Contracts\CountryRepository as ContractsCountryRepository;

class CountryRepository extends BaseRepository implements ContractsCountryRepository
{
    public function model()
    {
        return Country::class;
    }

    public static function getCountryList()
    {
        return Country::query()
            ->select(['countries_chinese_name', 'countries_name', 'countries_iso_code_2'])
            ->get()
            ->toArray();
    }

    public static function getCountryCodeByCountriesChineseName($name)
    {
        $country = Country::query()->where('countries_chinese_name', $name)->first();
        if (is_null($country)) {
            return "";
        } else {
            return $country->countries_iso_code_2;
        }
    }

    public static function getCountryCodeByCountriesName($name)
    {
        $country = Country::query()->where('countries_name', $name)->first();
        if (is_null($country)) {
            return "";
        } else {
            return $country->countries_iso_code_2;
        }
    }

    public static function getCountryByFlag($countries_id)
    {
        $country = Country::query()->where('countries_id', $countries_id)->first();
        if (is_null($country)) {
            return "";
        } else {
            return $country->flag;
        }
    }
}
