<?php


namespace Modules\Base\Contracts\Company;


use Illuminate\Http\Request;
use Modules\Base\Entities\Company\Company;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;

interface CompanyRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    /**
     * 获取公司日志信息
     * @return mixed
     */
    public function getStatusLog(Company $company);

    /**
     * 新增公司
     * @param  array  $companyData
     * @return mixed
     */
    public function store(array $companyData);

    /**
     * 更新公司
     * @param  Company  $company
     * @param  array  $companyData
     * @return mixed
     */
    public function updateCompany(Company $company, array $companyData);

    /**
     * 更新公司状态
     * @param  Company  $company
     * @return mixed
     */
    public function updateCompanyStatus(Company $company);

    /**
     * 更新公司联系人
     * @param  Company  $company
     * @param  array  $updateData
     * @return mixed
     */
    public function updateCompanyContacts(Company $company, array $updateData);

    /**
     * 获取公司银行信息
     * @param  Company  $company
     * @return mixed
     */
    public function getBanksInfo(Company $company);

    /**
     * 获取公司办公室信息
     * @param  Company  $company
     * @return mixed
     */
    public function getOfficeInfo(Company $company);

    /**
     * 获取公司仓库信息
     * @param  Company  $company
     * @return mixed
     */
    public function getWarehouseInfo(Company $company);

    /**
     * 获取单个公司的信息
     * @param  string  $uuid
     * @return mixed
     */
    public function getCompanyInfo(string $uuid);

    /**
     * 获取指定类型的公司信息
     * @param  int  $type
     * @return mixed
     */
    public function getTypeCompanies(int $type);

    /**
     * 新增公司税务信息
     * @param  Company  $company
     * @param  array  $taxInfo
     * @return mixed
     */
    public function storeTaxInfo(Company $company, array $taxInfo);

    /**
     * 更新公司税务信息
     * @param  Company  $company
     * @param  array  $taxInfo
     * @return mixed
     */
    public function  updateTaxInfo(Company $company, array $taxInfo);

    /**
     * 删除税务信息
     * @param  Company  $company
     * @param  array  $uuids
     * @return mixed
     */
    public function deleteTaxInfo(Company $company, array $uuids);

    /**
     * 根据id返回公司信息
     * @param  int  $id
     * @return mixed
     */
    public function getCompanyBaseInfo(int $id);
}
