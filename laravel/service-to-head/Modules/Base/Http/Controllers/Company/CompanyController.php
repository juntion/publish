<?php


namespace Modules\Base\Http\Controllers\Company;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Base\Contracts\Company\CompanyRepository;
use Modules\Base\Contracts\Company\CompanyService;
use Modules\Base\Contracts\Company\MediaRepository;
use Modules\Base\Contracts\ListServiceInterface;
use Modules\Base\Entities\Company\Company;
use Modules\Base\Enums\Company\AddressType;
use Modules\Base\Exceptions\Company\CompanyException;
use Modules\Base\Http\Controllers\Controller;
use Modules\Base\Http\Requests\Company\CompanyBankRequest;
use Modules\Base\Http\Requests\Company\CompanyListRequest;
use Modules\Base\Http\Requests\Company\CompanyOfficeRequest;
use Modules\Base\Http\Requests\Company\CompanyRegistrationRequest;
use Modules\Base\Http\Requests\Company\CompanyRequest;
use Modules\Base\Http\Requests\Company\CompanyWarehouseRequest;
use Modules\Base\Http\Requests\Company\StatusRequest;
use Modules\Base\Http\Resources\Company\BankResource;
use Modules\Base\Http\Resources\Company\CompanyInfoResource;
use Modules\Base\Http\Resources\Company\CompanyInfoResourceCollection;
use Modules\Base\Http\Resources\Company\CompanyListResource;
use Modules\Base\Http\Resources\Company\CompanyListResourceCollection;
use Modules\Base\Http\Resources\Company\OfficeOrWarehouseResource;
use Modules\Base\Http\Resources\Company\TypeCompanyResource;
use Modules\Base\Repositories\Company\CompanyBankAccountsRepository;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class CompanyController extends Controller
{

    /**
     * 获取所有公司列表
     * @param  CompanyListRequest  $listRequest
     * @param  ListServiceInterface  $listService
     * @return CompanyListResourceCollection
     */
    public function companies(CompanyListRequest $listRequest, ListServiceInterface $listService)
    {
        $model = Company::query()->orderBy('created_at', 'DESC');
        $listService->setRequest($listRequest);
        $listService->setBuilder($model);
        $companies = $listService->getResource();
        return new CompanyListResourceCollection($companies);
    }

    /**
     * 获取公司状态日志
     * @param  Request  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatusLog(Request $request, CompanyService $service)
    {
        $uuid = $request->uuid;
        $log = $service->getStatusLog($uuid);
        return $this->successWithData($log);
    }

    /**
     * 获取所有公司信息 含税务及注册信息
     * @param  CompanyListRequest  $listRequest
     * @param  ListServiceInterface  $listService
     * @return CompanyInfoResourceCollection
     */
    public function getAllInfo(CompanyListRequest $listRequest, ListServiceInterface $listService)
    {
        $model = Company::query()->with(['address' => function($q){
            return $q->with('media');
        },'taxInfo'])->orderBy('created_at', 'DESC');
        $listService->setRequest($listRequest);
        $listService->setBuilder($model);
        $companies = $listService->getResource();
        return new CompanyInfoResourceCollection($companies);
    }

    /**
     * 获取单个公司信息
     * @param  Request  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfo(Request $request, CompanyService $service)
    {
        $uuid = $request->uuid;
        $companies = $service->getInfo($uuid);
        $companies = new CompanyInfoResource($companies);
        return $this->successWithData(compact('companies'));
    }

    /**
     * 获取公司办公室信息
     * @param  Request  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOfficeInfo(Request $request, CompanyService $service)
    {
        $uuid = $request->uuid;
        $office = $service->getOfficeInfo($uuid);
        $offices = OfficeOrWarehouseResource::collection($office);
        return $this->successWithData(compact('offices'));
    }

    /**
     * @param  Request  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOfficeStatusLogs(Request $request, CompanyService $service)
    {
        $uuid = $request->uuid;
        $logs = $service->getAddressStatusLogs($uuid);
        return $this->successWithData($logs);
    }

    /**
     * 获取公司仓库信息
     * @param  Request  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWarehouseInfo(Request $request, CompanyService $service)
    {
        $uuid = $request->uuid;
        $warehouses = $service->getWarehouseInfo($uuid);
        $warehouses = OfficeOrWarehouseResource::collection($warehouses);
        return $this->successWithData(compact('warehouses'));
    }

    /**
     * 获取仓库状态日志
     * @param  Request  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWarehouseStatusLogs(Request $request, CompanyService $service)
    {
        $uuid = $request->uuid;
        $logs = $service->getAddressStatusLogs($uuid);
        return $this->successWithData($logs);
    }

    /**
     * 获取银行信息
     * @param  Request  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBankInfo(Request $request, CompanyService $service)
    {
        $uuid = $request->uuid;
        $banks = $service->getBankInfo($uuid);
        $banks = BankResource::collection($banks);
        return $this->successWithData(compact('banks'));
    }

    /**
     * 获取银行状态变动日志
     * @param  Request  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBankStatusLogs(Request $request, CompanyService $service)
    {
        $uuid = $request->uuid;
        $logs = $service->getBankStatusLogs($uuid);
        return $this->successWithData($logs);
    }

    /**
     * 获取指定类型公司
     * @param  Request  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTypeCompanies(Request $request, CompanyService $service)
    {
        $type = $request->type ?? 0;
        $companies = $service->getTypeCompanies($type);
        $companies = TypeCompanyResource::collection($companies);
        return $this->successWithData(compact('companies'));
    }

    /**
     * 创建公司
     * @param  CompanyRequest  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     * @throws CompanyException
     */
    public function store(CompanyRequest $request, CompanyService $service, CompanyRepository $companyRepository)
    {
        $company = $request->all();
        $company['uuid'] = Str::uuid()->getHex()->toString();
        if ($parent_uuid = $request->input('parent_uuid')) {
            $parent = $companyRepository->find($parent_uuid);
            $this->checkPIDIsTrue($request->input('type'), $parent);
            if ($parent->type == 1) {
                $company['one_level_uuid'] = $parent->uuid;
                $company['two_level_uuid'] = $company['uuid'];
            } else {
                $company['one_level_uuid'] = $parent->one_level_uuid;
                $company['two_level_uuid'] = $parent->two_level_uuid;
            }
        } else {
            $company['one_level_uuid'] = $company['uuid'];
        }
        $company = $service->storeCompany($company);
        return $this->successWithData(compact('company'), FoundationResponse::HTTP_CREATED);
    }

    /**
     * @param  CompanyRequest  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     * @throws CompanyException
     */
    public function update(CompanyRequest $request, CompanyService $service, CompanyRepository $companyRepository)
    {
        $update = $request->all();
        $update['uuid'] = $request->uuid;
        if ($parent_uuid = $request->input('parent_uuid')) {
            $parent = $companyRepository->find($parent_uuid);
            $this->checkPIDIsTrue($request->input('type'), $parent);
            if ($parent->type == 1) {
                $update['one_level_uuid'] = $parent->uuid;
                $update['two_level_uuid'] = $update['uuid'];
            } else {
                $update['one_level_uuid'] = $parent->one_level_uuid;
                $update['two_level_uuid'] = $parent->two_level_uuid;
            }
        } else {
            $update['one_level_uuid'] = $update['uuid'];
            $update['two_level_uuid'] = null;
        }
        $company = $service->updateCompany($request->uuid, $update);
        return $this->successWithData(compact('company'));
    }

    /**
     * 更新公司状态
     * @param  Request  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(StatusRequest $request, CompanyService $service)
    {
        $uuid = $request->uuid;
        $service->updateCompanyStatus($uuid);
        return $this->success();
    }

    /**
     * 更新办公室状态
     * @param  Request  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOfficeAddressStatus(StatusRequest $request, CompanyService $service)
    {
        $service->updateAddressStatus($request->uuid);
        return $this->success();
    }

    /**
     * 更新仓库状态
     * @param  Request  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateWarehouseAddressStatus(StatusRequest $request, CompanyService $service)
    {
        $service->updateAddressStatus($request->uuid);
        return $this->success();
    }

    /**
     * 更新银行状态
     * @param  Request  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateBankStatus(StatusRequest $request, CompanyService $service)
    {
        $service->updateBankStatus($request->uuid);
        return $this->success();
    }

    /**
     * 创建注册信息
     * @param  Request  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     * @throws CompanyException
     */
    public function storeRegistrationAddress(CompanyRegistrationRequest $request, CompanyService $service)
    {
        $addressData = $request->only(['name', 'foreign_name', 'country_name', 'country_code', 'province', 'city', 'area','address', 'tel', 'foreign_country_name', 'foreign_country_code', 'foreign_province', 'foreign_city', 'foreign_area', 'foreign_address', 'foreign_tel', 'foreign_postcode', 'postcode', 'comment']);
        $addressData['uuid'] = Str::uuid()->getHex()->toString();
        $addressData['type'] = AddressType::REGISTER_TYPE;

        $contacts = $request->input('contacts') ?? "";
        $files = $request->file('new_media') ?? [];
        $taxInfo = $request->input('tax') ?? [];
        $refreshCompany = $service->storeRegistrationAddress($request->uuid, $addressData, $contacts, $taxInfo, $files);
        $company = new CompanyInfoResource($refreshCompany);
        return $this->successWithData(compact('company'), FoundationResponse::HTTP_CREATED);
    }

    /**
     * 更新注册信息
     * @param  Request  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRegistrationAddress(CompanyRegistrationRequest $request, CompanyService $service)
    {
        $addressData = $request->only(['name', 'foreign_name', 'country_name', 'country_code', 'province', 'city', 'area','address', 'tel', 'foreign_country_name', 'foreign_country_code', 'foreign_province', 'foreign_city', 'foreign_area', 'foreign_address', 'foreign_tel', 'foreign_postcode', 'postcode', 'comment']);

        $contacts = $request->input('contacts') ?? "";
        $newFiles = $request->file('new_media') ?? [];
        $oldFiles = $request->input('old_media') ?? [];
        $taxInfo = $request->input('tax') ?? [];

        $company = $service->updateRegistrationAddress($request->uuid, $addressData, $contacts, $taxInfo, $newFiles, $oldFiles);
        $company = new CompanyInfoResource($company);
        return $this->successWithData(compact('company'));
    }

    /**
     * 新增办公室信息
     * @param  Request  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeOfficeAddress(CompanyOfficeRequest $request, CompanyService $service)
    {
        $addressData = $request->only(['name', 'foreign_name', 'country_name', 'country_code', 'province', 'city', 'area','address', 'tel', 'foreign_country_name', 'foreign_country_code', 'foreign_province', 'foreign_city', 'foreign_area', 'foreign_address', 'foreign_tel', 'foreign_postcode', 'postcode', 'comment']);
        $addressData['uuid'] = Str::uuid()->getHex()->toString();
        $addressData['type'] = AddressType::OFFICE_TYPE;

        $contacts = $request->input('contacts') ?? [];
        $files = $request->file('new_media') ?? [];

        $office = $service->storeOfficeAddress($request->uuid, $addressData, $files, $contacts);

        $office = new OfficeOrWarehouseResource($office);
        return $this->successWithData(compact('office'), FoundationResponse::HTTP_CREATED);
    }

    /**
     * 更新办公室信息
     * @param  Request  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOfficeAddress(CompanyOfficeRequest $request, CompanyService $service)
    {
        $addressData = $request->only(['name', 'foreign_name', 'country_name', 'country_code', 'province', 'city', 'area','address', 'tel', 'foreign_country_name', 'foreign_country_code', 'foreign_province', 'foreign_city', 'foreign_area', 'foreign_address', 'foreign_tel', 'foreign_postcode', 'postcode', 'comment']);

        $contacts = $request->input('contacts') ?? [];
        $newFiles = $request->file('new_media') ?? [];
        $oldFiles = $request->input('old_media') ?? [];
        $office = $service->updateOfficeAddress($request->uuid, $addressData, $newFiles, $oldFiles,$contacts);
        $office = new OfficeOrWarehouseResource($office);
        return $this->successWithData(compact('office'));
    }

    /**
     * 创建仓库信息
     * @param  Request  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeWarehouseAddress(CompanyWarehouseRequest $request, CompanyService $service)
    {
        $addressData = $request->only(['name', 'foreign_name', 'country_name', 'country_code', 'province', 'city', 'area','address', 'tel', 'foreign_country_name', 'foreign_country_code', 'foreign_province', 'foreign_city', 'foreign_area', 'foreign_address', 'foreign_tel', 'foreign_postcode', 'postcode', 'comment']);
        $addressData['uuid'] = Str::uuid()->getHex()->toString();
        $addressData['type'] = AddressType::WAREHOUSE_TYPE;

        $contacts = $request->input('contacts') ?? [];
        $files = $request->file('new_media') ?? [];

        $warehouse = $service->storeOfficeAddress($request->uuid, $addressData, $files, $contacts);
        $warehouse = new OfficeOrWarehouseResource($warehouse);
        return $this->successWithData(compact('warehouse'), FoundationResponse::HTTP_CREATED);
    }

    /**
     * 更新仓库信息
     * @param  Request  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateWarehouseAddress(CompanyWarehouseRequest $request, CompanyService $service)
    {
        $addressData = $request->only(['name', 'foreign_name', 'country_name', 'country_code', 'province', 'city', 'area','address', 'tel', 'foreign_country_name', 'foreign_country_code', 'foreign_province', 'foreign_city', 'foreign_area', 'foreign_address', 'foreign_tel', 'foreign_postcode', 'postcode', 'comment']);

        $contacts = $request->input('contacts') ?? [];
        $newFiles = $request->file('new_media') ?? [];
        $oldFiles = $request->input('old_media') ?? [];

        $warehouse = $service->updateWarehouseAddress($request->uuid, $addressData, $newFiles, $oldFiles, $contacts);
        $warehouse = new OfficeOrWarehouseResource($warehouse);
        return $this->successWithData(compact('warehouse'));
    }


    /**
     * @param  CompanyBankRequest  $request
     * @param  CompanyService  $service
     * @return \Illuminate\Http\JsonResponse
     * @throws CompanyException
     */
    public function storeBank(CompanyBankRequest $request, CompanyService $service, CompanyBankAccountsRepository $companyBankAccountsRepository)
    {
        $bankData = $request->only(['check_address', 'comment', 'bank_name', 'other_info', 'account_name']);
        $bankData['uuid'] = Str::uuid()->getHex()->toString();
        $accountInfos = $request->input('account_info') ?? [];

        $this->checkAccountInfo($accountInfos, $companyBankAccountsRepository);

        $media = $request->file('new_media') ?? [];

        $bank = $service->storeBank($request->uuid, $bankData, $accountInfos, $media);
        $bank = new BankResource($bank);
        return $this->successWithData(compact('bank'), FoundationResponse::HTTP_CREATED);
    }

    /**
     * 更新银行账户信息
     * @param  CompanyBankRequest  $request
     * @param  CompanyService  $service
     * @param  CompanyBankAccountsRepository  $companyBankAccountsRepository
     * @return \Illuminate\Http\JsonResponse
     * @throws CompanyException
     */
    public function updateBank(CompanyBankRequest $request, CompanyService $service, CompanyBankAccountsRepository $companyBankAccountsRepository)
    {
        $bankData = $request->only(['check_address', 'comment', 'bank_name', 'other_info', 'account_name']);

        $accountInfos = $request->input('account_info') ?? [];

        $this->checkAccountInfo($accountInfos, $companyBankAccountsRepository);

        $newMedia = $request->file('new_media') ?? [];
        $oldMedia = $request->input('old_media') ?? [];

        $bank = $service->updateBank($request->uuid, $bankData, $accountInfos, $newMedia, $oldMedia);
        $bank = new BankResource($bank);
        return $this->successWithData(compact('bank'));
    }


    /**
     * @param $type
     * @param  Company  $parent
     * @return bool
     * @throws CompanyException
     */
    protected function checkPIDIsTrue($type, Company $parent)
    {
        if ($type == 1) {
            throw new CompanyException(__('base::company.motherCompanyCantSetParent'));
        }
        $p_type = $parent->type;

        if ($type == 2 && !in_array($p_type,[1,2])) {
            throw new CompanyException(__('base::company.childCompanyOnlyBeChildOrMother'));
        }

        if ($type == 3 && $p_type == 3){
            throw new CompanyException(__('base::company.branchCompanyNotBranch'));
        }
        return true;
    }

    /**
     * 资源下载
     * @param  Request  $request
     * @param  MediaRepository  $mediaRepository
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download(Request $request, MediaRepository $mediaRepository)
    {
        $media = $mediaRepository->find($request->uuid);
        $path = $media->path;
        return Storage::disk('base')->download($path, $media->name);
    }

    /**
     * @param  Request  $request
     * @param  CompanyRepository  $repository
     * @return \Illuminate\Http\JsonResponse
     */
    public function companiesList(Request $request, CompanyRepository $repository)
    {
        $companies = $repository->findByField('status', 1, ['uuid', 'name', 'code']);
        $companies = CompanyListResource::collection($companies);
        return $this->successWithData(compact('companies'));
    }

    /**
     * @param  array  $accountsInfo
     * @param  CompanyBankAccountsRepository  $companyBankAccountsRepository
     * @throws CompanyException
     */
    protected function checkAccountInfo(array $accountsInfo, CompanyBankAccountsRepository $companyBankAccountsRepository)
    {
        $currencyPaymentArr = [];
        foreach ($accountsInfo as $item) {
            $key = $item['payment_method_id'] . '-' . $item['currency_code'];
            if (isset($currencyPaymentArr[$key])) {
                throw new CompanyException(__('base::company.existSeamBankAccountInfo'));
            }
            $currencyPaymentArr[$key] = 1;
            $account = $companyBankAccountsRepository->getAccountInfoByMethodAndCurrency($item['payment_method_id'], $item['currency_code'], $item['uuid'] ?? '');
            if (!is_null($account)) {
                throw new CompanyException(__('base::company.existSeamBankAccountInfo'));
            }
        }
    }
}
