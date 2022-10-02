<?php


namespace App\Contracts\Rpc;


interface CompanyInterface
{
    /**
     * @return mixed
     */
    public function getCountry();

    public function getCurrencies();
}
