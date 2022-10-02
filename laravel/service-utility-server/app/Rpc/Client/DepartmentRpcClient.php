<?php

namespace App\Rpc\Client;

use App\Contracts\Rpc\DepartmentRpcInterface;
use App\Exceptions\Rpc\RpcException;
use App\Rpc\RpcClient;

class DepartmentRpcClient implements DepartmentRpcInterface
{
    /**
     * @return \Hprose\Proxy|mixed
     */
    private function getClient()
    {
        return RpcClient::department();
    }

    /**
     * @param array $department
     * @param $parentId
     * @return mixed
     * @throws RpcException
     */
    public function store(array $department, $parentId)
    {
        try {
            return $this->getClient()->store($department, $parentId);
        } catch (\Exception $e) {
            throw new RpcException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $departmentId
     * @param array $data
     * @return mixed
     * @throws RpcException
     */
    public function update($departmentId, array $data)
    {
        try {
            return $this->getClient()->update($departmentId, $data);
        } catch (\Exception $e) {
            throw new RpcException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $departmentId
     * @return mixed
     * @throws RpcException
     */
    public function delete($departmentId)
    {
        try {
            return $this->getClient()->delete($departmentId);
        } catch (\Exception $e) {
            throw new RpcException($e->getMessage(), $e->getCode());
        }
    }
}
