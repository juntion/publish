<?php

namespace App\Rpc\Client;

use App\Contracts\Rpc\PermissionRpcInterface;
use App\Exceptions\Rpc\RpcException;
use App\Rpc\RpcClient;

class PermissionRpcClient implements PermissionRpcInterface
{
    /**
     * @return \Hprose\Proxy|mixed
     */
    private function getClient()
    {
        return RpcClient::permission();
    }

    /**
     * @param array $data
     * @return mixed
     * @throws RpcException
     */
    public function profiles(array $data)
    {
        try {
            return $this->getClient()->profiles($data);
        } catch (\Exception $e) {
            throw  new RpcException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $userId
     * @return mixed
     * @throws RpcException
     */
    public function userProfiles($userId)
    {
        try {
            return $this->getClient()->userProfiles($userId);
        } catch (\Exception $e) {
            throw  new RpcException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $userId
     * @param $profileIds
     * @return mixed
     * @throws RpcException
     */
    public function settingPermissions($userId, $profileIds)
    {
        try {
            return $this->getClient()->settingPermissions($userId, $profileIds);
        } catch (\Exception $e) {
            throw  new RpcException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $userId
     * @param $profileId
     * @return mixed
     * @throws RpcException
     */
    public function deleteProfile($userId, $profileId)
    {
        try {
            return $this->getClient()->deleteProfile($userId, $profileId);
        } catch (\Exception $e) {
            throw  new RpcException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $userIds
     * @param $profileIds
     * @return mixed
     * @throws RpcException
     */
    public function assignPermissions($userIds, $profileIds)
    {
        try {
            return $this->getClient()->assignPermissions($userIds, $profileIds);
        } catch (\Exception $e) {
            throw  new RpcException($e->getMessage(), $e->getCode());
        }
    }
}
