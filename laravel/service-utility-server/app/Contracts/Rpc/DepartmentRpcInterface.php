<?php

namespace App\Contracts\Rpc;

interface DepartmentRpcInterface
{
    /**
     * @param array $department
     * @param $parentId
     * @return mixed
     */
    public function store(array $department, $parentId);

    /**
     * @param $departmentId
     * @param array $data
     * @return mixed
     */
    public function update($departmentId, array $data);

    /**
     * @param $departmentId
     * @return mixed
     */
    public function delete($departmentId);
}
