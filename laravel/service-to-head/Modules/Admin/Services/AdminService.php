<?php


namespace Modules\Admin\Services;

use Modules\Admin\Contracts\AdminRepository;
use Modules\Admin\Contracts\AdminService as ContractsAdminService;
use Modules\Admin\Entities\Admin;
use Modules\ERP\Contracts\AdminSalesAssistantService as ContractsAdminSalesAssistantService;
use Modules\ERP\Contracts\AdminSalesAssistantRepository;
use Illuminate\Support\Arr;
use Modules\Admin\Exceptions\AdminException;


class AdminService implements ContractsAdminService
{
    protected $adminRepository;
    protected $adminSalesAssistantService;
    protected $salesAssistantRepository;

    public function __construct(AdminRepository $adminRepository, ContractsAdminSalesAssistantService $adminSalesAssistantService,
                                AdminSalesAssistantRepository $salesAssistantRepository)
    {
        $this->adminRepository = $adminRepository;
        $this->adminSalesAssistantService = $adminSalesAssistantService;
        $this->salesAssistantRepository = $salesAssistantRepository;
    }

    public function getAdminGroup($uuid)
    {
        return $this->adminRepository->getAdminGroup($uuid);
    }

    public function getAdminInfoById($id)
    {
        return $this->adminRepository->getAdminInfoByOriginId($id);
    }

    /**
     * 得到同组用户
     *
     * @param Admin $admin
     * @return \Modules\Share\Entities\Collection
     */
    public function getGroupAdmins(Admin $admin)
    {
        $adminCollection = collect([]);

        $leaderId = $this->getAdminGroupId($admin);

        $adminCollection->push($leaderId);

        $salesInfo = $this->salesAssistantRepository->getSaleAssistant([$leaderId]);

        if ($salesInfo->isNotEmpty()) {
            $salesIds = array_column($salesInfo->toArray(), 'assistant');
            $adminCollection->push($salesIds);

            $assistantInfo = $this->salesAssistantRepository->getSaleAssistant($salesIds);
            if ($assistantInfo->isNotEmpty()) {
                $assistantIds = array_column($assistantInfo->toArray(), 'assistant');
                $adminCollection->push($assistantIds);
            }
        }

        $adminCollection = Arr::flatten($adminCollection);
        return $this->adminRepository->getAdminsByErpIds($adminCollection);
    }

    /**
     * 得到用户组唯一标识
     *
     * @param Admin $admin
     * @throws \Exception
     * @return int
     */
    public function getAdminGroupId(Admin $admin)
    {
        $leaderInfo = $this->adminSalesAssistantService->getSalesLeader($admin);
        if ($leaderInfo->isNotEmpty()) {
            return $leaderInfo->first()->admin_id;
        }

        throw new AdminException(__('admin::adminServer.getLeaderErr'));
    }
}
