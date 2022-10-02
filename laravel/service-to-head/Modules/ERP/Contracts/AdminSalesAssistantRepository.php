<?php

namespace Modules\ERP\Contracts;

use Modules\Admin\Entities\Admin;


interface AdminSalesAssistantRepository
{
    /**
     * 获取销售的下级
     *
     * @param Admin $admin
     * @return mixed
     */
    public static function getNextSale(Admin $admin);

    /**
     * 获取销售的上级
     *
     * @param Admin $admin
     * @return mixed
     */
    public static function getPrevSale(Admin $admin);

    /**
     * 获取指定销售下级的所有销售
     *
     * @param $adminIds array
     * @return mixed
     */
    public static function getSaleAssistant(array $adminIds);
}