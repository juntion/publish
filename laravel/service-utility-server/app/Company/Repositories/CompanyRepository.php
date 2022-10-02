<?php


namespace App\Company\Repositories;


use App\Company\Models\Company;
use App\Company\Models\CompanyAddressInfo;
use App\Company\Models\CompanyPay;
use App\Enums\Company\AddressType;
use App\Exceptions\Company\CompanyException;
use App\Http\Resources\Company\CompanyBankResource;
use App\Http\Resources\Company\CompanyOfficeResource;
use App\Http\Resources\Company\CompanyResource;
use App\Repositories\BaseRepository;
use App\Support\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyRepository extends BaseRepository
{


    protected $model;

    protected $allowedSorts = ['number'];
    public function __construct(Company $company)
    {
        $this->model = $company;
    }
    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function list()
    {
        $this->orderBy("number", "ASC");
        $limit = \request()->input('limit') ?? 20;
        $data = $this->getModelsList($limit);
        return $data;
    }

    /**
     * @param Request $request
     * @throws CompanyException
     */
    public function addCompany(Request $request)
    {
        $addData = $request->only(['type', "company_simple_name", "main_tag", "company_name", "company_english_name", "time_zone", "profile", "is_show", "status", "p_id", "country"]);
        $this->checkPIDIsTrue($request);
        Company::query()->create($addData);
    }

    /**
     * 更新公司信息
     * @param Request $request
     * @throws CompanyException
     */
    public function updateCompany(Request $request)
    {
        $id = $request->id;
        $Company = Company::query()->find($id);
        if (!$Company){
            throw new CompanyException("参数错误，未找到对应的公司");
        }
        $this->checkPIDIsTrue($request);
        $updateData = $request->only(['type', "company_simple_name", "main_tag", "company_name", "company_english_name", "time_zone", "profile", "is_show", "status", "p_id", "country"]);
        $Company->update($updateData);
    }

    /**
     * 验证父级公司是否正确
     * @param Request $request
     * @return bool
     * @throws CompanyException
     */
    protected function checkPIDIsTrue(Request $request)
    {
        $p_id = $request->input("p_id");
        $type = $request->input("type");
        if ($type == 1 && $p_id) {
            throw new CompanyException("公司类型为母公司时 不能设置父级公司");
        }
        $p_company = Company::query()->find($p_id);
        if (!$p_company && $type != 1){
            throw new CompanyException("父级公司id错误 未找到对应的公司");
        }
        $p_type = $p_company ? $p_company->type : null;

        if ($type == 2 && !in_array($p_type,[1,2])) {
            throw new CompanyException("公司类型为子公司时 父级公司类型只能为母公司或子公司");
        }

        if ($type == 3 && $p_type == 3){
            throw new CompanyException("公司类型为分公司时 父级公司不能也为分公司");
        }
        return true;
    }

    /**
     * 获取母公司分公司的树状数据
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTreeData()
    {
        $data = Company::query()
            ->select("type", "id", "company_simple_name")
            ->where("type", 1)
            ->with("child")
            ->get();
        return $data;
    }

    /**
     * 更新公司状态
     * @param Request $request
     * @return bool
     * @throws CompanyException
     */
    public function changeStatus(Request $request)
    {
        $id = $request->id;
        $Company = Company::query()->find($id);
        if (!$Company){
            throw new CompanyException("参数错误，未找到对应的公司");
        }
        $status = $Company->status;
        $updateData = [
          'status' => $status == 1 ? 0 : 1,
        ];
        $Company->update($updateData);
        return true;
    }

    /**
     * 获取状态记录
     * @param Request $request
     * @return mixed
     * @throws CompanyException
     */
    public function companyStatusLog(Request $request)
    {
        $id = $request->id;
        $Company = Company::query()->find($id);
        if (!$Company){
            throw new CompanyException("参数错误，未找到对应的公司");
        }
        $data = $Company->logs();
        return $data;
    }

    /**
     * 更新注册信息
     * @param Request $request
     * @throws CompanyException
     */
    public function updateCompanyRegistry(Request $request)
    {
        $id = $request->route('id');
        $company = Company::query()->find($id);
        if (!$company){
            throw new CompanyException("参数错误，未找到对应的公司");
        }

        DB::beginTransaction();
        try{
            $companyUpdateData = [];
            $companyUpdateData['contacts'] = $request->input('contacts');

            $addressData = $request->only(['name', 'en_name', 'country', 'province', 'city', 'area','address', 'tel', 'en_country', 'en_province', 'en_city', 'en_area', 'en_address', 'en_tel']);
            $company->update($companyUpdateData);
            $addressData['type'] = 1;
            $address = $company->address()->updateOrCreate(['company_id'=> $id], $addressData);
            $id_arr = collect($request->input("tax"))->where('id','>', 0)->pluck('id')->all();
            if (!empty($id_arr)) {
                $company->taxInfo()->whereNotIn('id', $id_arr)->delete();
            } else {
                $company->taxInfo()->delete();
            }
            if($request->has('tax')){
                foreach ($request->input("tax") as $item){
                    if (isset($item['id'])){
                        $updateData['country'] = $item['country'];
                        $updateData['tax_number'] = $item['tax_number'];
                        $company->taxInfo()->where('id', $item['id'])->update($updateData);
                    } else {
                        $company->taxInfo()->create($item);
                    }
                }
            }
            $old_media = $request->input('old_media') ?? [];
            $new_media = $request->file('new_media') ?? [];
            $this->uploadFile($old_media, $new_media, $address);
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error("更新注册信息失败" . $exception);
            throw new CompanyException("更新注册信息失败");
        }
        DB::commit();
    }

    /**
     * 上传附件
     * @param array $oldMedia
     * @param $newMedia
     * @param Model $model
     */
    protected function uploadFile(array $oldMedia, $newMedia, Model $model)
    {
        if (empty($oldMedia)){
            $model->media()->delete();
        } else {
            $del_media = $model->media()->whereNotIn('id',$oldMedia)->delete();
        }
        if (!empty($newMedia)){
            collect($newMedia)->map(function ($media)use ($model){
                $path = Upload::addFile($media)->save();
                $model->moveTmpMedia($model->getMediaCollection(), $path, true);
            });
        }
    }

    /**
     * 更新办公室信息
     * @param Request $request
     * @throws CompanyException
     */
    public function updateCompanyOffice(Request $request)
    {
        $id = $request->route('id');
        $company = Company::query()->find($id);
        if (!$company){
            throw new CompanyException("参数错误，未找到对应的公司");
        }
        DB::beginTransaction();
        try {
            $item = $request->all();
            $file = $request->file();
            $id = $item['id'] ?? 0;
            $updateData = collect($item)->only(['name', 'en_name', 'country', 'province', 'city','area', 'address', 'tel', 'en_country', 'en_province', 'en_city', 'en_area', 'en_address', 'en_tel', 'postcode', 'en_postcode','comment'])->toArray();
            $updateData['type'] = AddressType::OFFICE_TYPE;
            if ($id) {
                $office = $company->office()->where('id', $id)->first();
                if (is_null($office)){
                    throw new CompanyException("办公室id错误，未找到对应的办公室");
                }
                $office->update($updateData);
            } else {
                $office = $company->office()->create($updateData);
            }
            $id_arr = [];
            $contacts = [];
            if (isset($item['contacts'])){
                $contacts = $item['contacts'];
                $id_arr = collect($item['contacts'])->where('id','>',0)->pluck('id')->all();
            }
            if (!empty($id_arr)) {
                $office->contacts()->whereNotIn('id', $id_arr)->delete();
            } else {
                $office->contacts()->delete();
            }
            foreach ($contacts as $v) {
                $office_data['contacts'] = $v['contacts'];
                $office_data['tel'] = $v['tel'];
                $office_data['type'] = $v['type'];
                if (isset($v['id'])) {
                    $c = $office->contacts()->where('id', $v['id'])->first();
                    if (is_null($c)) {
                        throw new CompanyException("参数错误，未找到对应的联系人id");
                    }
                    $c->update($office_data);
                } else {
                    $office->contacts()->create($office_data);
                }
            }
            $old_media = $item['old_media'] ?? [];
            $new_media = $file['new_media'] ?? [];
            $this->uploadFile($old_media, $new_media, $office);
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error("更新办公室信息失败:". $exception);
            if ($exception instanceof CompanyException){
                throw new CompanyException($exception->getMessage());
            }
            throw new CompanyException("更新办公室信息失败");
        }
        DB::commit();
    }

    /**
     * 更新办公室状态
     * @param Request $request
     * @param $type
     * @throws CompanyException
     */
    public function updateOfficeStatus(Request $request, $type)
    {
        $id = $request->route('id');
        $address= CompanyAddressInfo::query()->where('type', $type)->find($id);
        if (!$address){
            throw new CompanyException("参数错误，未找到对应的信息");
        }
        $updateData['status'] = $address->status == 1 ? 0 : 1;
        $address->update($updateData);
    }

    /**
     * 办公室状态日志
     * @param Request $request
     * @param $type
     * @return mixed
     * @throws CompanyException
     */
    public function officeStatusLogs(Request $request, $type)
    {
        $id = $request->route('id');
        $address= CompanyAddressInfo::query()->where('type', $type)->find($id);
        if (!$address){
            throw new CompanyException("参数错误，未找到对应的信息");
        }
        $data['logs'] = $address->logs();
        return $data;
    }

    /**
     * @param Request $request
     * @throws CompanyException
     */
    public function updateCompanyWarehouse(Request $request)
    {
        $id = $request->route('id');
        $company = Company::query()->find($id);
        if (!$company){
            throw new CompanyException("参数错误，未找到对应的公司");
        }
        DB::beginTransaction();
        try {
            $item = $request->all();
            $file = $request->file();
            $id = $item['id'] ?? 0;
            $updateData = collect($item)->only(['name', 'en_name', 'country', 'area','province', 'city', 'address', 'tel', 'en_country', 'en_province', 'en_city', 'en_area', 'en_address', 'en_tel', 'postcode', 'en_postcode','comment'])->toArray();
            $updateData['type'] = AddressType::WAREHOUSE_TYPE;
            if ($id) {
                $warehouse = $company->warehouse()->where('id', $id)->first();
                if (is_null($warehouse)){
                    throw new CompanyException("仓库id错误，未找到对应的仓库");
                }
                $warehouse->update($updateData);
            } else {
                $warehouse = $company->warehouse()->create($updateData);
            }
            $contacts = $id_arr = [];
            if (isset($item['contacts'])){
                $contacts = $item['contacts'];
                $id_arr = collect($item['contacts'])->where('id',">", 0)->pluck('id')->all();
            }
            if (!empty($id_arr)) {
                $warehouse->contacts()->whereNotIn('id', $id_arr)->delete();
            }else {
                $warehouse->contacts()->delete();
            }
            foreach ($contacts as $v) {
                $office_data['contacts'] = $v['contacts'];
                $office_data['tel'] = $v['tel'];
                $office_data['type'] = $v['type'];
                if (isset($v['id'])) {
                    $c = $warehouse->contacts()->where('id', $v['id'])->first();
                    if (is_null($c)) {
                        throw new CompanyException("参数错误，未找到对应的联系人id");
                    }
                    $c->update($office_data);
                } else {
                    $warehouse->contacts()->create($office_data);
                }
            }
            $old_media = $item['old_media'] ?? [];
            $new_media = $file['new_media'] ?? [];
            $this->uploadFile($old_media, $new_media, $warehouse);
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error("更新仓库信息失败:". $exception);
            if ($exception instanceof CompanyException){
                throw new CompanyException($exception->getMessage());
            }
            throw new CompanyException("更新仓库信息失败");
        }
        DB::commit();
    }

    /**
     * 支付信息日志
     * @param Request $request
     * @return mixed
     * @throws CompanyException
     */
    public function bankLogs(Request $request)
    {
        $id = $request->route('id');
        $companyPay = CompanyPay::query()->find($id);
        if (!$companyPay){
            throw new CompanyException("参数错误，未找到支付信息id");
        }
        $data['logs'] = $companyPay->logs();
        return $data;
    }

    /**
     * 更新支付信息
     * @param Request $request
     * @return bool
     * @throws CompanyException
     */
    public function updateBankStatus(Request $request)
    {
        $id = $request->id;
        $companyPay = CompanyPay::query()->find($id);
        if (!$companyPay){
            throw new CompanyException("参数错误，未找到对应的信息");
        }
        $updateData['status'] = $companyPay->status == 1 ? 0 : 1;
        $companyPay->update($updateData);
        return true;
    }

    /**
     * 更新支付信息
     * @param Request $request
     * @return bool
     * @throws CompanyException
     */
    public function updatePayInfo(Request $request)
    {
        $id = $request->route('id');
        $company = Company::query()->find($id);
        if (!$company){
            throw new CompanyException("参数错误，未找到对应的公司");
        }
        DB::beginTransaction();
        try {
            $bank = $request->all();
            $file = $request->file();
            $pay_info = collect($bank)->only(['pay_method', 'check_address', 'comment', 'bank_name', 'other_info', 'account_name'])->toArray();
            if (isset($bank['id'])){
                $pay = $company->banks()->where('id', $bank['id'])->first();
                if (is_null($pay)){
                    throw new CompanyException("参数错误未找到对应id的支付信息");
                }
                $pay->update($pay_info);
            } else {
                $pay = $company->banks()->create($pay_info);
            }
            $account_infos = $bank['account_info'];
            $id_arr = collect($account_infos)->where('id',">", 0)->pluck('id')->all();
            if (!empty($id_arr)) {
                $pay->accountInfos()->whereNotIn('id', $id_arr)->delete();
            }else {
                $pay->accountInfos()->delete();
            }
            foreach ($account_infos as $info){
                if(isset($info['id'])) {
                    $fields = $pay->accountInfos()->where('id', $info['id'])->first();
                    if (is_null($fields)){
                        throw new CompanyException("参数错误未找到对应的账户信息");
                    }
                    $fields->update($info);
                } else {
                    $pay->accountInfos()->create($info);
                }
            }
            $old_media = $bank['old_media'] ?? [];
            $new_media = $file['new_media'] ?? [];
            $this->uploadFile($old_media, $new_media, $pay);
        }catch (\Exception $exception){
            DB::rollBack();
            dd($exception);
            \Log::error("更新支付信息失败:". $exception);
            if ($exception instanceof CompanyException){
                throw new CompanyException($exception->getMessage());
            }
            throw new CompanyException("更新支付信息失败");
        }
        DB::commit();
        return true;
    }


    /**
     * @param Request $request
     * @return array
     * @throws CompanyException
     */
    public function getCompanyInfo(Request $request)
    {
        $id = $request->id;
        $company = Company::query()->with("address","taxInfo","warehouse","office","banks")->find($id);
        if (!$company){
            throw new CompanyException("参数错误，未找到对应的公司");
        }
        $office = CompanyOfficeResource::collection($company->office);
        $warehouse = CompanyOfficeResource::collection($company->warehouse);
        $bank = CompanyBankResource::collection($company->banks);
        $company = new CompanyResource($company);
        $data =  compact('company','warehouse','office','bank');
        return $data;
    }


    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getAllInfo()
    {
        $companys = Company::query()->where('is_show', 1)->orderBy("number", "ASC")->get();
        $data = CompanyResource::collection($companys);
        return $data;
    }

    /**
     * @param Request $request
     * @return array
     * @throws CompanyException
     */
    public function getCompanyOffice(Request $request)
    {
        $id = $request->id;
        $company = Company::query()->find($id);
        if (!$company){
            throw new CompanyException("参数错误，未找到对应的公司");
        }
        $offices = CompanyOfficeResource::collection($company->office);
        $data =  compact('offices');
        return $data;
    }

    /**
     * @param Request $request
     * @return array
     * @throws CompanyException
     */
    public function getCompanyWarehouse(Request $request)
    {
        $id = $request->id;
        $company = Company::query()->find($id);
        if (!$company){
            throw new CompanyException("参数错误，未找到对应的公司");
        }
        $warehouses = CompanyOfficeResource::collection($company->warehouse);
        $data =  compact('warehouses');
        return $data;
    }

    /**
     * @param Request $request
     * @return array
     * @throws CompanyException
     */
    public function getCompanyBank(Request $request)
    {
        $id = $request->id;
        $company = Company::query()->find($id);
        if (!$company){
            throw new CompanyException("参数错误，未找到对应的公司");
        }
        $banks = CompanyBankResource::collection($company->banks);
        $data =  compact('banks');
        return $data;
    }

    /**
     * 获取某种类型下的所有公司
     * @param Request $request
     * @return array
     */
    public function getTypeCompany(Request $request)
    {
        $type = $request->input('type', 1);
        $company = Company::query()->select('company_name','id')->where('type',$type)->get()->toArray();
        return compact('company');
    }
}
