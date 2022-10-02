<?php

namespace App\Support\RpcMock;

use App\Contracts\Rpc\UserRpcInterface;

class UserRpcMock extends BaseRpcMock implements UserRpcInterface
{
    public function assistantLevel(array $types)
    {
        $data = json_decode('[{"assistant_id":"104","assistant_name":"英语","type":"0","pid":"0","sort":"99","customer_limit":"0","rank":"0"},{"assistant_id":"105","assistant_name":"销售岗","type":"1","pid":"104","sort":"99","customer_limit":"0","rank":"0"},{"assistant_id":"106","assistant_name":"管理岗（业务）","type":"1","pid":"104","sort":"99","customer_limit":"0","rank":"0"},{"assistant_id":"107","assistant_name":"管理岗（非业务）","type":"1","pid":"104","sort":"99","customer_limit":"0","rank":"0"},{"assistant_id":"108","assistant_name":"多语言","type":"0","pid":"0","sort":"99","customer_limit":"0","rank":"0"}]', true);
        return $this->success($data);
    }

    public function setAssistantLevel($userId, $assistantId)
    {
        return $this->success();
    }

    public function adminLevel()
    {
        $data = json_decode('[{"profile_id":"1","profile_name":"超级管理员","type":"0","warehouse":"0","department":"1","temp":"0","info":"该权限为公司最高级别，能查看大部分页面","AddTime":"0000-00-00 00:00:00"},{"profile_id":"2","profile_name":"Sales","type":"1","warehouse":"0","department":"1","temp":"0","info":"","AddTime":"0000-00-00 00:00:00"},{"profile_id":"3","profile_name":"SEO管理员","type":"7","warehouse":"0","department":"10","temp":"0","info":"","AddTime":"0000-00-00 00:00:00"},{"profile_id":"4","profile_name":"西语超级管理员","type":"1","warehouse":"0","department":"1","temp":"0","info":"","AddTime":"0000-00-00 00:00:00"}]', true);
        return $this->success($data);
    }

    public function updatePassword($userId, $password)
    {
        return $this->success();
    }

    public function store(array $user, $departmentId, $baseDepartmentId, $companyId)
    {
        return $this->success(['user_id' => random_int(1, 9999)]);
    }

    public function department($userId, $departmentId, $baseDepartmentId)
    {
        return $this->success();
    }

    public function duties($userId, $duties)
    {
        return $this->success();
    }

    public function update($userId, $data)
    {
        return $this->success();
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function delete($userId)
    {
        return $this->success();
    }

    public function adminStatus($userId)
    {
        return $this->success();
    }

    public function setAvatar($userId, $avatarData)
    {
        return $this->success();
    }
}
