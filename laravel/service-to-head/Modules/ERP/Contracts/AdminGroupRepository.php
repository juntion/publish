<?php


namespace Modules\ERP\Contracts;


use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

interface AdminGroupRepository extends RepositoryInterface,RepositoryCriteriaInterface
{
    /**
     * 获取用户group
     * @param $id
     * @return mixed
     */
    public function getAdminGroup($id);

    /**
     * 获取用户相同组的所有用户id
     * @param $id
     * @return mixed
     */
    public function getSeamGroupAdmins($id);
}
