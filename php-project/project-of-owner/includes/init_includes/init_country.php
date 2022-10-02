<?php
use App\Services\Country\CountryService;
//初始化全局country
global $countryService;
$countryService = new CountryService();
