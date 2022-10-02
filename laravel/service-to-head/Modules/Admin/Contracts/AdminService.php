<?php


namespace Modules\Admin\Contracts;

use Modules\Admin\Entities\Admin;


interface AdminService
{
    public function getAdminGroup($uuid);

    public function getAdminInfoById($id);

    /**
     * 得到同组用户
     *
     * @param Admin $admin
     */
    public function getGroupAdmins(Admin $admin);

    /**
     * 得到用户组唯一标识
     *
     * @param Admin $admin
     */
    public function getAdminGroupId(Admin $admin);
}
