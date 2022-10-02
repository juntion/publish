<?php

namespace App\Rpc\Client;
use App\Contracts\Rpc\CompanyInterface;
use App\Contracts\Rpc\DepartmentRpcInterface;
use App\Exceptions\Rpc\RpcException;
use App\Rpc\RpcClient;
use Illuminate\Support\Facades\Cache;

class CompanyRpcClient implements CompanyInterface
{

    /**
     * @return \Hprose\Proxy|mixed
     */
    private function getClient()
    {
        return RpcClient::company();
    }

    /**
     * @return mixed
     * @throws RpcException
     */
    public function getCountry()
    {
        try {
            $data =  $this->getClient()->getCountry();
        } catch (\Exception $e) {
            throw  new RpcException($e->getMessage(), $e->getCode());
        }
        return $data;
    }

    public function getCurrencies()
    {
        try {
            $data =  $this->getClient()->getCurrencies();
        } catch (\Exception $e) {
            throw  new RpcException($e->getMessage(), $e->getCode());
        }
        return $data;
    }
}
