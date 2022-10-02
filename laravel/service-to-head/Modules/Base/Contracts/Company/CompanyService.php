<?php


namespace Modules\Base\Contracts\Company;


use Illuminate\Http\Request;

interface CompanyService
{
    /**
     * 获取公司状态日志
     * @param  string  $uuid
     * @return mixed
     */
    public function getStatusLog(string $uuid);

    /**
     * 获取指定公司信息
     * @param  string  $uuid
     * @return mixed
     */
    public function getInfo(string $uuid);

    /**
     * 获取指定公司办公室信息
     * @param  string  $uuid
     * @return mixed
     */
    public function getOfficeInfo(string $uuid);

    /**
     * 获取指定公司仓库信息
     * @param  string  $uuid
     * @return mixed
     */
    public function getWarehouseInfo(string $uuid);

    /**
     * 获取地址信息变更日志
     * @param  string  $uuid
     * @return mixed
     */
    public function getAddressStatusLogs(string $uuid);

    /**
     * 获取银行信息
     * @param  string  $uuid
     * @return mixed
     */
    public function getBankInfo(string $uuid);

    /**
     * 获取指定银行状态变更日志
     * @param  string  $uuid
     * @return mixed
     */
    public function getBankStatusLogs(string $uuid);

    /**
     * 获取指定类型公司数据
     * @param  int  $type
     * @return mixed
     */
    public function getTypeCompanies(int $type);

    /**
     * 新建公司
     * @param  array  $companyData
     * @return mixed
     */
    public function storeCompany(array $companyData);

    /**
     * 更新指定公司信息
     * @param  string  $uuid
     * @param  array  $companyData
     * @return mixed
     */
    public function updateCompany(string $uuid, array $companyData);

    /**
     * 更新公司状态
     * @param  string  $uuid
     * @return mixed
     */
    public function updateCompanyStatus(string $uuid);

    /**
     * 更新地址状态
     * @param  string  $uuid
     * @return mixed
     */
    public function updateAddressStatus(string $uuid);

    /**
     * 更新银行状态
     * @param  string  $uuid
     * @return mixed
     */
    public function updateBankStatus(string $uuid);

    /**
     * 新增注册地址信息
     * @param  string  $uuid
     * @param  array  $addressData
     * @param  array  $contacts
     * @param  array  $taxInfo
     * @param  array  $files
     * @return mixed
     */
    public function storeRegistrationAddress(string $uuid, array $addressData,array $contacts, array $taxInfo, array $files);

    /**
     * 更新注册地址信息
     * @param  string  $uuid
     * @param  array  $addressData
     * @param  array  $contacts
     * @param  array  $taxInfo
     * @param  array  $newMedia
     * @param  array  $oldMedia
     * @return mixed
     */
    public function updateRegistrationAddress(string $uuid, array $addressData,array $contacts, array $taxInfo, array $newMedia, array $oldMedia);

    /**
     * 新增公司办公室信息
     * @param  string  $uuid
     * @param  array  $officeData
     * @param  array  $files
     * @param $contacts
     * @return mixed
     */
    public function storeOfficeAddress(string $uuid, array $officeData, array $files, $contacts);

    /**
     * 更新办公室信息
     * @param  string  $uuid
     * @param  array  $officeData
     * @param  array  $newMedia
     * @param  array  $oldMedia
     * @param $contacts
     * @return mixed
     */
    public function updateOfficeAddress(string $uuid, array $officeData, array $newMedia, array $oldMedia, $contacts);

    /**
     * 新增仓库信息
     * @param  string  $uuid
     * @param  array  $officeData
     * @param  array  $files
     * @param $contacts
     * @return mixed
     */
    public function storeWarehouseAddress(string $uuid, array $officeData, array $files, $contacts);

    /**
     * 更新仓库信息
     * @param  string  $uuid
     * @param  array  $officeData
     * @param  array  $newMedia
     * @param  array  $oldMedia
     * @param $contacts
     * @return mixed
     */
    public function updateWarehouseAddress(string $uuid, array $officeData, array $newMedia, array $oldMedia, $contacts);

    /**
     * 新增银行信息
     * @param  string  $uuid
     * @param  array  $bankData
     * @param  array  $accountInfos
     * @param  array  $newMedia
     * @return mixed
     */
    public function storeBank(string $uuid, array $bankData, array $accountInfos, array $newMedia);

    /**
     * 更新指定银行信息
     * @param  string  $uuid
     * @param  array  $bankData
     * @param  array  $accountInfos
     * @param  array  $newMedia
     * @param  array  $oldMedia
     * @return mixed
     */
    public function updateBank(string $uuid, array $bankData, array $accountInfos, array $newMedia, array $oldMedia);
}
