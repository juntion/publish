<?php


namespace Modules\Base\Contracts\Company;

use Modules\Base\Entities\Company\Company;
use Modules\Base\Entities\Company\CompanyAddress;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

interface AddressRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    /**
     * 获取地址状态 变动日志
     * @param  CompanyAddress  $companyAddress
     * @return mixed
     */
    public function getStatusLogs(CompanyAddress $companyAddress);

    /**
     * 更新地址状态
     * @param  CompanyAddress  $companyAddress
     * @return mixed
     */
    public function updateStatus(CompanyAddress $companyAddress);

    /**
     * 新增一个地址信息
     * @param  Company  $company 公司
     * @param  array  $addressData 地址数据
     * @return mixed
     */
    public function store(Company $company, array $addressData);

    /**
     * 更新指定地址的信息
     * @param  array  $addressData
     * @param  CompanyAddress  $address
     * @return mixed
     */
    public function updateAddress(array $addressData, CompanyAddress $addres);

    /**
     * 新增联系人
     * @param  CompanyAddress  $address
     * @param $contact
     * @return mixed
     */
    public function storeContacts(CompanyAddress $address, $contact);

    /**
     * 删除联系人
     * @param  CompanyAddress  $address
     * @param  array  $uuids
     * @return mixed
     */
    public function deleteContacts(CompanyAddress $address, array $uuids);

    /**
     * 更新联系信息
     * @param  CompanyAddress  $address
     * @param  array  $contact
     * @return mixed
     */
    public function updateContacts(CompanyAddress $address, array $contact = []);
}
