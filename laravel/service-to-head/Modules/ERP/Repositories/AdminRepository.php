<?php

namespace Modules\ERP\Repositories;

use Modules\Admin\Entities\Admin;
use Modules\ERP\Entities\Admin as ErpAdmin;
use Modules\ERP\Contracts\AdminRepository as ContractsAdminRepository;


class AdminRepository implements ContractsAdminRepository
{
    public static function roleIsLeader(Admin $admin)
    {
        return ErpAdmin::where([['admin_id', $admin->id], ['is_leader', '>', 0]])->get();
    }

    public static function getAdmin(Admin $admin)
    {
        return ErpAdmin::where('admin_id', $admin->id)->get();
    }

    public static function getAdmins(array $adminIds)
    {
        return ErpAdmin::whereIn('admin_id', $adminIds)->get();
    }
}