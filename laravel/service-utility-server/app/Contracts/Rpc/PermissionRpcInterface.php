<?php

namespace App\Contracts\Rpc;

interface PermissionRpcInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function profiles(array $data);

    /**
     * @param $userId
     * @return mixed
     */
    public function userProfiles($userId);

    /**
     * @param $userId
     * @param $profileIds
     * @return mixed
     */
    public function settingPermissions($userId, $profileIds);

    /**
     * @param $userId
     * @param $profileId
     * @return mixed
     */
    public function deleteProfile($userId, $profileId);

    /**
     * @param $userIds
     * @param $profileIds
     * @return mixed
     */
    public function assignPermissions($userIds, $profileIds);
}
