<?php

namespace App\Contracts\Rpc;

interface UserRpcInterface
{
    /**
     * @param array $types
     * @return mixed
     */
    public function assistantLevel(array $types);

    /**
     * @param $userId
     * @param $assistantId
     * @return mixed
     */
    public function setAssistantLevel($userId, $assistantId);

    /**
     * @return mixed
     */
    public function adminLevel();

    /**
     * @param $userId
     * @param $password
     * @return mixed
     */
    public function updatePassword($userId, $password);

    /**
     * @param array $user
     * @param int $departmentId
     * @param int $baseDepartmentId
     * @param $companyId
     * @return mixed
     */
    public function store(array $user, $departmentId, $baseDepartmentId, $companyId);

    /**
     * @param int $userId
     * @param int $departmentId
     * @param int $baseDepartmentId
     * @return mixed
     */
    public function department($userId, $departmentId, $baseDepartmentId);

    /**
     * @param int $userId
     * @param int $duties
     * @return mixed
     */
    public function duties($userId, $duties);

    /**
     * @param int $userId
     * @param array $data
     * @return mixed
     */
    public function update($userId, $data);

    /**
     * @param $userId
     * @return mixed
     */
    public function delete($userId);

    /**
     * @param $userId
     * @return mixed
     */
    public function adminStatus($userId);

    /**
     * @param int $userId
     * @param array $avatarData
     * @return mixed
     */
    public function setAvatar($userId, $avatarData);
}
