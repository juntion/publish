<?php

namespace App\Http\Controllers\Company;

use App\Company\Repositories\CompanyRepository;
use App\Contracts\Rpc\CompanyInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CompanyRequest;
use App\Http\Requests\Company\CompanyStatusRequest;
use App\Http\Requests\Company\UpdateCompanyOfficeRequest;
use App\Http\Requests\Company\UpdateCompanyPayRequest;
use App\Http\Requests\Company\UpdateCompanyRegistryRequest;
use App\Http\Requests\Company\UpdateCompanyWarehouseRequest;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * 子公司列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected $company;
    public function __construct(CompanyRepository $company)
    {
        parent::__construct();
        $this->company = $company;
    }
    /**
     * 获取公司列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $data = $this->company->list();
        return $this->successWithData($data);
    }

    public function getTreeData()
    {
        $data = $this->company->getTreeData();
        return $this->successWithData($data);
    }

    /**
     * 新增公司
     * @param CompanyRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Company\CompanyException
     */
    public function addCompany(CompanyRequest $request)
    {
        $this->company->addCompany($request);
        return $this->success();
    }

    /**
     * 更新公司
     * @param CompanyRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Company\CompanyException
     */
    public function updateCompany(CompanyRequest $request)
    {
        $this->company->updateCompany($request);
        return $this->success();
    }

    /**
     * 更新公司状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Company\CompanyException
     */
    public function changeStatus(CompanyStatusRequest $request)
    {
        $this->company->changeStatus($request);
        return $this->success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Company\CompanyException
     */
    public function companyStatusLog(Request $request)
    {
        $data = $this->company->companyStatusLog($request);
        return $this->successWithData($data);
    }

    /**
     * 更新注册信息
     * @param UpdateCompanyRegistryRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Company\CompanyException
     */
    public function updateCompanyRegistry(UpdateCompanyRegistryRequest $request)
    {
        $this->company->updateCompanyRegistry($request);
        return $this->success();
    }

    /**
     * 更新办公室信息
     * @param UpdateCompanyOfficeRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Company\CompanyException
     */
    public function updateCompanyOffice(UpdateCompanyOfficeRequest $request)
    {
        $this->company->updateCompanyOffice($request);
        return $this->success();
    }

    /**
     * 办公室状态变更
     * @param CompanyStatusRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Company\CompanyException
     */
    public function updateOfficeStatus(CompanyStatusRequest $request)
    {
        $this->company->updateOfficeStatus($request, 2);
        return $this->success();
    }

    /**
     * 办公室日志
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Company\CompanyException
     */
    public function officeStatusLogs(Request $request)
    {
        $data = $this->company->officeStatusLogs($request, 2);
        return $this->successWithData($data);
    }

    /**
     * 仓库状态变更
     * @param CompanyStatusRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Company\CompanyException
     */
    public function updateWarehouseStatus(CompanyStatusRequest $request)
    {
        $this->company->updateOfficeStatus($request, 3);
        return $this->success();
    }

    /**
     * 仓库日志
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Company\CompanyException
     */
    public function warehouseStatusLogs(Request $request)
    {
        $data = $this->company->officeStatusLogs($request, 3);
        return $this->successWithData($data);
    }

    /**
     *仓库变更日志
     * @param UpdateCompanyWarehouseRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Company\CompanyException
     */
    public function updateCompanyWarehouse(UpdateCompanyWarehouseRequest $request)
    {
        $this->company->updateCompanyWarehouse($request);
        return $this->success();
    }

    /**
     * 仓库日志
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Company\CompanyException
     */
    public function bankLogs(Request $request)
    {
        $data = $this->company->bankLogs($request);
        return $this->successWithData($data);
    }

    /**
     *仓库变更日志
     * @param UpdateCompanyWarehouseRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Company\CompanyException
     */
    public function updateBankStatus(CompanyStatusRequest $request)
    {
        $this->company->updateBankStatus($request);
        return $this->success();
    }

    /**
     * 更新支付信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Company\CompanyException
     */
    public function updatePayInfo(UpdateCompanyPayRequest $request)
    {
        $this->company->updatePayInfo($request);
        return $this->success();
    }

    /**
     * 获取公司具体信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Company\CompanyException
     */
    public function getCompanyInfo(Request $request)
    {
        $data = $this->company->getCompanyInfo($request);
        return $this->successWithData($data);
    }

    /**
     * RPC 获取国家信息
     * @param CompanyInterface $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCountry(CompanyInterface $company)
    {
//        if (Cache::tags(['uums','company','country'])->has('country')){
//            $data =  Cache::tags(['uums','company','country'])->get('country');
//            return $this->successWithData($data);
//        }
        $result = $company->getCountry();
        if ($result['status'] == 'success') {
            $data = $result['data'];
//            Cache::tags(['uums','company','country'])->put('country', $data, 7*24*3600);
            return $this->successWithData($result['data']);
        }
        return $this->failed();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function allInfo(Request $request)
    {
        $data = $this->company->getAllInfo();
        return $this->successWithData($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Company\CompanyException
     */
    public function getCompanyOffice(Request $request)
    {
        $data = $this->company->getCompanyOffice($request);
        return $this->successWithData($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Company\CompanyException
     */
    public function getCompanyWarehouse(Request $request)
    {
        $data = $this->company->getCompanyWarehouse($request);
        return $this->successWithData($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Company\CompanyException
     */
    public function getCompanyBank(Request $request)
    {
        $data = $this->company->getCompanyBank($request);
        return $this->successWithData($data);
    }

    public function getCurrencies(CompanyInterface $company)
    {
        $result = $company->getCurrencies();
        if ($result['status'] == 'success') {
            return $this->successWithData($result['data']);
        }
        return $this->failed();
    }

    /**
     * 获取某种类型下的所有公司
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTypeCompany(Request $request)
    {
        $request = $this->company->getTypeCompany($request);
        return $this->successWithData($request);
    }

}
