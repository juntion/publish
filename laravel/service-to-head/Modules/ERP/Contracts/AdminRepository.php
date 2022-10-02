<?php

namespace Modules\ERP\Contracts;

use Modules\Admin\Entities\Admin;


interface AdminRepository
{
    /**
     * 判断当前用户是否为组长
     *
     * @param Admin $admin
     * @return mixed
     */
    public static function roleIsLeader(Admin $admin);

    /**
     * 根据财务系统admin信息获取erp系统admin信息
     *
     * @param Admin $admin
     * @return mixed
     */
    public static function getAdmin(Admin $admin);

    /**
     * 批量获取erp系统admin信息
     *
     * @param array $adminIds
     * @return mixed
     */
    public static function getAdmins(array $adminIds);
}