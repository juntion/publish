<?php

namespace Modules\ERP\Service;

use Modules\ERP\Contracts\AdminSalesAssistantService as ContractsAdminSalesAssistantService;
use Modules\Admin\Entities\Admin;
use Modules\ERP\Contracts\AdminSalesAssistantRepository;
use Modules\ERP\Contracts\AdminRepository as ErpAdminRepository;
use Modules\Admin\Contracts\AdminRepository;


class AdminSalesAssistantService implements ContractsAdminSalesAssistantService
{
    protected $salesAssistantRepository;
    protected $erpAdminRepository;
    protected $adminRepository;

    public function __construct(AdminSalesAssistantRepository $salesAssistantRepository, ErpAdminRepository $erpAdminRepository, AdminRepository $adminRepository)
    {
        $this->salesAssistantRepository = $salesAssistantRepository;
        $this->erpAdminRepository = $erpAdminRepository;
        $this->adminRepository = $adminRepository;
    }

    public function getSalesLeader(Admin $admin)
    {
        // 是否为Leader
        $checkIsLeader = $this->erpAdminRepository->roleIsLeader($admin);

        if ($checkIsLeader->isNotEmpty()) { //是Leader
            return $this->erpAdminRepository->getAdmin($admin);
        }

        $prevSale = $this->salesAssistantRepository->getPrevSale($admin);
        if (!is_null($prevSale)) {
            $admins = $this->adminRepository->getAdminByErpID($prevSale->sales);
            if ($admins->isNotEmpty()) {
                $admins = $admins->first();
                return $this->getSalesLeader($admins);
            }
        }

        return $this->erpAdminRepository->getAdmin($admin);
    }
}