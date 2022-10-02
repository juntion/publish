<?php


namespace Modules\ERP\Repositories;


use Modules\ERP\Contracts\AdminGroupRepository as ContractsAdminGroupRepository;
use Modules\ERP\Entities\Admin;
use Prettus\Repository\Eloquent\BaseRepository;

class AdminGroupRepository extends BaseRepository implements ContractsAdminGroupRepository
{
    public function model()
    {
        return Admin::class;
    }

    /**
     * 获取用户group
     * @param $id
     * @return mixed
     */
    public function getAdminGroup($id)
    {

    }

    /**
     * 获取用户相同组的所有用户id
     * @param $id
     * @return mixed
     */
    public function getSeamGroupAdmins($id)
    {

    }
}
