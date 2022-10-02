<?php

namespace Modules\ERP\Contracts;

use Modules\Admin\Entities\Admin;


interface AdminSalesAssistantService
{
    /**
     * 获取当前销售的Leader 返回erp系统admin模型
     *
     * @return mixed
     */
    public function getSalesLeader(Admin $admin);
}