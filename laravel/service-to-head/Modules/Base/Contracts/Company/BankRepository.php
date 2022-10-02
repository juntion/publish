<?php


namespace Modules\Base\Contracts\Company;


use Illuminate\Http\Request;
use Modules\Base\Entities\Company\Company;
use Modules\Base\Entities\Company\CompanyBank;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

interface BankRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    /**
     * 银行状态日志
     * @param  CompanyBank  $companyBank
     * @return mixed
     */
    public function getStatusLogs(CompanyBank $companyBank);

    /**
     * 更新银行状态
     * @param  CompanyBank  $companyBank
     * @return mixed
     */
    public function updateStatus(CompanyBank $companyBank);

    /**
     * 创建银行信息
     * @param  Company  $company
     * @param  array  $bankData
     * @return mixed
     */
    public function store(Company $company, array $bankData);

    /**
     * 更新指定银行信息
     * @param  CompanyBank  $companyBank
     * @param  array  $bankData
     * @return mixed
     */
    public function updateBank(CompanyBank $companyBank, array $bankData);

    public function storeAccountInfo(CompanyBank $companyBank, array $accountInfo);

    public function deleteAccountInfo(CompanyBank $companyBank, array $uuids);

    public function updateAccountInfo(CompanyBank $companyBank, array $accountInfo);
}
