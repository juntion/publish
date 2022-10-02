<?php

namespace App\Support\RpcMock;

use App\Contracts\Rpc\DepartmentRpcInterface;

class DepartmentRpcMock extends BaseRpcMock implements DepartmentRpcInterface
{
    public function store(array $department, $parentId)
    {
        return $this->success(['id' => random_int(1, 9999)]);
    }

    public function update($departmentId, array $data)
    {
        return $this->success();
    }

    public function delete($departmentId)
    {
        return $this->success();
    }
}
