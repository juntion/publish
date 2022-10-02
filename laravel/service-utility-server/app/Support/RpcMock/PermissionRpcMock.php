<?php

namespace App\Support\RpcMock;

use App\Contracts\Rpc\PermissionRpcInterface;

class PermissionRpcMock extends BaseRpcMock implements PermissionRpcInterface
{
    public function profiles(array $data)
    {
        $data = json_decode('[{"profile_id":"34","profile_name":"录单领款权限","department":"0","temp":"1"},{"profile_id":"35","profile_name":"批量复制产品","department":"0","temp":"1"},{"profile_id":"36","profile_name":"批量转移产品","department":"0","temp":"1"},{"profile_id":"37","profile_name":"批量关闭产品","department":"0","temp":"1"},{"profile_id":"40","profile_name":"小语种负责人","department":"0","temp":"1"}]', true);
        return $this->success($data);
    }

    public function userProfiles($userId)
    {
        $data = json_decode('[{"profile_id":"80","profile_name":"诉求负责人","department":"0","temp":"1"},{"profile_id":"103","profile_name":"文件共享自删","department":"0","temp":"1"},{"profile_id":"139","profile_name":"FS须知发布权限","department":"0","temp":"1"}]', true);
        return $this->success($data);
    }

    public function settingPermissions($userId, $profileIds)
    {
        return $this->success();
    }

    public function deleteProfile($userId, $profileId)
    {
        return $this->success();
    }

    public function assignPermissions($userIds, $profileIds)
    {
        return $this->success();
    }
}
