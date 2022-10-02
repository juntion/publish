<?php

namespace Modules\ERP\Repositories;

use Modules\Admin\Entities\Admin;
use Modules\ERP\Contracts\AdminSalesAssistantRepository as ContractsAdminSalesAssistantRepository;
use Modules\ERP\Entities\AdminSalesAssistant;


class AdminSalesAssistantRepository implements ContractsAdminSalesAssistantRepository
{
    /**
     * 获取销售的下级
     *
     * @param Admin $admin
     * @return mixed
     */
    public static function getNextSale(Admin $admin)
    {
        return AdminSalesAssistant::where('sales', $admin->id)->first();
    }

    /**
     * 获取销售的上级
     *
     * @param Admin $admin
     * @return mixed
     */
    public static function getPrevSale(Admin $admin)
    {
        return AdminSalesAssistant::where('assistant', $admin->id)->first();
    }

    /**
     * 获取指定销售下级的所有销售
     *
     * @param $adminIds array
     * @return mixed
     */
    public static function getSaleAssistant(array $adminIds)
    {
        return AdminSalesAssistant::whereIn('sales', $adminIds)->get();
    }
}