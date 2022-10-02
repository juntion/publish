<?php

namespace App\Rpc\Client;

use App\Contracts\Rpc\UserRpcInterface;
use App\Exceptions\Rpc\RpcException;
use App\Rpc\RpcClient;

class UserRpcClient implements UserRpcInterface
{
    /**
     * @return \Hprose\Proxy|mixed
     */
    private function getClient()
    {
        return RpcClient::user();
    }

    /**
     * @param array $types
     * @return mixed
     * @throws RpcException
     */
    public function assistantLevel(array $types)
    {
        try {
            return $this->getClient()->assistantLevel($types);
        } catch (\Exception $e) {
            throw new RpcException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $userId
     * @param $assistantId
     * @return mixed
     * @throws RpcException
     */
    public function setAssistantLevel($userId, $assistantId)
    {
        try {
            return $this->getClient()->setAssistantLevel($userId, $assistantId);
        } catch (\Exception $e) {
            throw new RpcException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @return mixed
     * @throws RpcException
     */
    public function adminLevel()
    {
        try {
            return $this->getClient()->adminLevel();
        } catch (\Exception $e) {
            throw new RpcException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $userId
     * @param $password
     * @return mixed
     * @throws RpcException
     */
    public function updatePassword($userId, $password)
    {
        try {
            return $this->getClient()->updatePassword($userId, $password);
        } catch (\Exception $e) {
            throw new RpcException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param array $user
     * @param int $departmentId
     * @param int $baseDepartmentId
     * @param $companyId
     * @return mixed
     * @throws RpcException
     */
    public function store(array $user, $departmentId, $baseDepartmentId, $companyId)
    {
        try {
            return $this->getClient()->store($user, $departmentId, $baseDepartmentId, $companyId);
        } catch (\Exception $e) {
            throw new RpcException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param int $userId
     * @param int $departmentId
     * @param int $baseDepartmentId
     * @return mixed
     * @throws RpcException
     */
    public function department($userId, $departmentId, $baseDepartmentId)
    {
        try {
            return $this->getClient()->department($userId, $departmentId, $baseDepartmentId);
        } catch (\Exception $e) {
            throw new RpcException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param int $userId
     * @param int $duties
     * @return mixed
     * @throws RpcException
     */
    public function duties($userId, $duties)
    {
        try {
            return $this->getClient()->duties($userId, $duties);
        } catch (\Exception $e) {
            throw new RpcException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param int $userId
     * @param array $data
     * @return mixed
     * @throws RpcException
     */
    public function update($userId, $data)
    {
        try {
            return $this->getClient()->update($userId, $data);
        } catch (\Exception $e) {
            throw new RpcException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $userId
     * @return mixed
     * @throws RpcException
     */
    public function delete($userId)
    {
        try {
            return $this->getClient()->delete($userId);
        } catch (\Exception $e) {
            throw new RpcException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $userId
     * @return mixed
     * @throws RpcException
     */
    public function adminStatus($userId)
    {
        try {
            return $this->getClient()->adminStatus($userId);
        } catch (\Exception $e) {
            throw new RpcException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param int $userId
     * @param array $avatarData
     * @return mixed
     * @throws RpcException
     */
    public function setAvatar($userId, $avatarData)
    {
        try {
            return $this->getClient()->setAvatar($userId, $avatarData);
        } catch (\Exception $e) {
            throw new RpcException($e->getMessage(), $e->getCode());
        }
    }
}
