<?php


namespace Modules\Base\Services\Company;

use Illuminate\Http\Request;
use Modules\Base\Contracts\Company\AddressRepository;
use Modules\Base\Contracts\Company\BankRepository;
use Modules\Base\Contracts\Company\CompanyBankAccountsRepository;
use Modules\Base\Contracts\Company\CompanyService as Service;
use Modules\Base\Contracts\Company\CompanyRepository;
use Modules\Base\Exceptions\Company\CompanyException;

class CompanyService implements Service
{
    protected $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param  Request  $request
     * @return mixed
     */
    public function getStatusLog(string $uuid)
    {
        $company =  $this->companyRepository->find($uuid);
        return $this->companyRepository->getStatusLog($company);
    }

    public function getInfo(string $uuid)
    {
        $company = $this->companyRepository->getCompanyInfo($uuid);
        return $company;
    }

    public function getOfficeInfo(string $uuid)
    {
        $company = $this->companyRepository->find($uuid);
        $office = $this->companyRepository->getOfficeInfo($company);
        return $office;
    }

    public function getWarehouseInfo(string $uuid)
    {
        $company = $this->companyRepository->find($uuid);
        $warehouse = $this->companyRepository->getWarehouseInfo($company);
        return $warehouse;
    }

    public function getAddressStatusLogs(string $uuid)
    {
        $addressRepository = app()->make(AddressRepository::class);
        $log = $addressRepository->getStatusLogs($addressRepository->find($uuid));
        return $log;
    }

    public function getBankInfo(string $uuid)
    {
        $company = $this->companyRepository->find($uuid);
        $banks = $this->companyRepository->getBanksInfo($company);
        return $banks;
    }

    public function getBankStatusLogs(string $uuid)
    {
        $bankRepository = app()->make(BankRepository::class);
        $bank = $bankRepository->find($uuid);
        $logs= $bankRepository->getStatusLogs($bank);
        return $logs;
    }

    public function getTypeCompanies(int $type)
    {
        $companies = $this->companyRepository->getTypeCompanies($type);
        return $companies;
    }

    public function storeCompany(array $companyData)
    {
        return $this->companyRepository->store($companyData);
    }

    public function updateCompany(string $uuid,array $companyData)
    {
        $company = $this->companyRepository->find($uuid);
        return $this->companyRepository->updateCompany($company, $companyData);
    }

    public function updateCompanyStatus(string $uuid)
    {
        $company = $this->companyRepository->find($uuid);
        $this->companyRepository->updateCompanyStatus($company);
        return true;
    }

    public function updateAddressStatus(string $uuid)
    {
        $addressRepository = app()->make(AddressRepository::class);
        $address = $addressRepository->find($uuid);
        $addressRepository->updateStatus($address);
        return true;
    }

    public function updateBankStatus(string $uuid)
    {
        $bankRepository = app()->make(BankRepository::class);
        $bank = $bankRepository->find($uuid);
        $bankRepository->updateStatus($bank);
        return true;
    }

    /**
     * @param  Request  $request
     * @return mixed
     * @throws CompanyException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function storeRegistrationAddress(string $uuid, array $addressData, $contacts, array $taxInfo = [], array $files = [])
    {
        $addressRepository = app()->make(AddressRepository::class);
        $company = $this->companyRepository->find($uuid);
        if ($company->address){
            throw new CompanyException(__('base::company.companyHasRegistrationAddress'));
        }

        $update = [
            'contacts' => $contacts
        ];
        $this->companyRepository->updateCompanyContacts($company, $update);

        foreach ($taxInfo as $item){
            $this->companyRepository->storeTaxInfo($company, $item);
        }

        $address = $addressRepository->store($company, $addressData);
        $addressRepository->addMedia($address, $files);
        return $company->refresh();
    }

    /**
     * @param  Request  $request
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function updateRegistrationAddress(string $uuid, array $addressData, $contacts, array $taxInfo, array $newMedia, $oldMedia)
    {
        $addressRepository = app()->make(AddressRepository::class);
        $address = $addressRepository->find($uuid);
        $company = $address->company;
        $update = [
            'contacts' => $contacts
        ];
        $this->companyRepository->updateCompanyContacts($company, $update);

        foreach ($taxInfo as $item){
            if (isset($item['uuid'])){
                $this->companyRepository->updateTaxInfo($company, $item);
            } else {
                $this->companyRepository->storeTaxInfo($company, $item);
            }
        }
        $addressRepository->deleteMedia($address, $oldMedia);
        $addressRepository->addMedia($address, $newMedia);

        $addressRepository->updateAddress($addressData, $address);

        return $company->refresh();
    }


    /**
     * 新增银行信息
     * @param  Request  $request
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function storeBank(string $uuid, array $bankData, array $accountInfos, array $newMedia)
    {
        $company = $this->companyRepository->find($uuid);
        $bankRepository = app()->make(BankRepository::class);

        $bank = $bankRepository->store($company, $bankData);

        foreach ($accountInfos as $accountInfo){
            $bankRepository->storeAccountInfo($bank, $accountInfo);
        }
        $bankRepository->addMedia($bank, $newMedia);

        return $bank->refresh();
    }

    /**
     * 更新银行信息
     * @param  Request  $request
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function updateBank(string $uuid, array $bankData, array $accountInfos, array $newMedia, array $oldMedia)
    {
        $bankRepository = app()->make(BankRepository::class);
        $bank = $bankRepository->find($uuid);
        $bank = $bankRepository->updateBank($bank, $bankData);

        $bankAccountRepository = app()->make(CompanyBankAccountsRepository::class);
        $uuid = collect($accountInfos)->where('uuid', '!=', "")->pluck('uuid')->all();
        $bankRepository->deleteAccountInfo($bank, $uuid);
        collect($accountInfos)->where('uuid', '=', "")->each(function ($item)use($bankRepository,$bank){
            $bankRepository->storeAccountInfo($bank, $item);
        });
        collect($accountInfos)->where('uuid', '!=', "")->each(function ($item)use($bankAccountRepository){
            $bankAccountRepository->updateAccountInfoById($item['uuid'], $item);
        });

        $bankRepository->deleteMedia($bank, $oldMedia);
        $bankRepository->addMedia($bank, $newMedia);

        return $bank->refresh();
    }


    /**
     * 创建办公室信息
     * @param  Request  $request
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function storeOfficeAddress(string $uuid, array $officeData, array $files, $contacts)
    {
        $company = $this->companyRepository->find($uuid);
        $addressRepository = app()->make(AddressRepository::class);
        $address = $addressRepository->store($company, $officeData);

        foreach ($contacts as $contact){
            $addressRepository->storeContacts($address, $contact);
        }
        $addressRepository->addMedia($address, $files);
        return $address->refresh();
    }

    /**
     * 更新办公室信息
     * @param  Request  $request
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function updateOfficeAddress(string $uuid, array $officeData, array $newMedia, array $oldMedia, $contacts)
    {
        $addressRepository = app()->make(AddressRepository::class);
        $address = $addressRepository->find($uuid);

        $addressRepository->deleteMedia($address, $oldMedia);
        $addressRepository->addMedia($address, $newMedia);

        $uuids = collect($contacts)->where('uuid', '!=', "")->pluck('uuid')->all();

        $addressRepository->deleteContacts($address, $uuids);

        foreach ($contacts as $contact) {
            if(isset($contact['uuid'])) {
                $addressRepository->updateContacts($address, $contact);
            } else {
                $addressRepository->storeContacts($address, $contact);
            }
        }

        $address = $addressRepository->updateAddress($officeData, $address);
        return $address->refresh();
    }

    /**
     * 创建仓库信息
     * @param  Request  $request
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function storeWarehouseAddress(string $uuid, array $warehouseData, array $files, $contacts)
    {
        $company = $this->companyRepository->find($uuid);
        $addressRepository = app()->make(AddressRepository::class);
        $address = $addressRepository->store($company, $warehouseData);

        foreach ($contacts as $contact){
            $addressRepository->storeContacts($address, $contact);
        }

        $addressRepository->addMedia($address, $files);

        return $address->refresh();
    }

    /**
     * 更新仓库信息
     * @param  Request  $request
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function updateWarehouseAddress(string $uuid, array $warehouseData, array $newMedia, array $oldMedia, $contacts)
    {
        $addressRepository = app()->make(AddressRepository::class);
        $address = $addressRepository->find($uuid);

        $addressRepository->deleteMedia($address, $oldMedia);
        $addressRepository->addMedia($address, $newMedia);

        $uuids = collect($contacts)->where('uuid', '!=', "")->pluck('uuid')->all();

        $addressRepository->deleteContacts($address, $uuids);

        foreach ($contacts as $contact) {
            if(isset($contact['uuid'])) {
                $addressRepository->updateContacts($address, $contact);
            } else {
                $addressRepository->storeContacts($address, $contact);
            }
        }

        $address = $addressRepository->updateAddress($warehouseData, $address);
        return $address->refresh();
    }

}
