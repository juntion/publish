<?php


namespace Modules\Base\Repositories\Company;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Base\Contracts\Company\CompanyRepository as ContractsCompanyRepository;
use Modules\Base\Entities\Company\Company;
use Modules\Base\Exceptions\Company\CompanyException;
use Modules\Base\Http\Resources\Company\CompanyResource;
use Prettus\Repository\Eloquent\BaseRepository;

class CompanyRepository extends BaseRepository implements ContractsCompanyRepository
{
    public function model()
    {
        return Company::class;
    }

    public function getStatusLog(Company $company)
    {
        return $company->logs();
    }

    /**
     * @param  Request  $request
     * @return CompanyResource
     * @throws CompanyException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(array $companyData)
    {
        $store = $this->create($companyData);
        $store = $store->refresh();
        return new CompanyResource($store);
    }


    /**
     * @param  Request  $request
     * @param  Company  $company
     * @return CompanyResource
     * @throws CompanyException
     */
    public function updateCompany(Company $company, array $companyData)
    {
        $company->update($companyData);
        $companyData = $company->refresh();
        return new CompanyResource($companyData);
    }

    public function updateCompanyStatus(Company $company)
    {
        $status = $company->status == 1 ? 0 : 1;
        $company->update([
           'status' => $status
        ]);
        return true;
    }

    /**
     * 更新指定数据
     * @param  Company  $company
     * @param  array  $updateData
     * @return bool
     */
    public function updateCompanyContacts(Company $company, array $updateData)
    {
        $company->update($updateData);
        return true;
    }

    public function getBanksInfo(Company $company)
    {
        return $company->banks()->with('media', 'bankAccount')->get();
    }

    public function getOfficeInfo(Company $company)
    {
        return $company->office()->with('media', 'contacts', 'foreignContacts')->get();
    }

    public function getWarehouseInfo(Company $company)
    {
         return $company->warehouse()->with('media', 'contacts', 'foreignContacts')->get();
    }

    public function getCompanyInfo(string $uuid)
    {
        return $this->with(['address' => function($q){
            return $q->with('media');
        },'taxInfo'])->find($uuid);
    }

    public function getTypeCompanies(int $type)
    {
        if ($type ==0) {
            return $this->orderBy('created_at', 'DESC')->get();
        }
        return $this->orderBy('created_at', 'DESC')->findWhere([
            'type' => $type
        ]);
    }

    public function storeTaxInfo(Company $company, array $taxInfo)
    {
        $taxInfo['uuid'] = Str::uuid()->getHex()->toString();
        $company->taxInfo()->create($taxInfo);
    }

    public function deleteTaxInfo(Company $company, array $uuids)
    {
        if (!empty($uuids)) {
            $company->taxInfo()->whereNotIn('uuid', $uuids)->delete();
        } else {
            $company->taxInfo()->delete();
        }
    }

    public function updateTaxInfo(Company $company, array $taxInfo)
    {
        $old = $company->taxInfo()->find($taxInfo['uuid']);
        if (!is_null($old)){
            $old->update($taxInfo);
        }
    }


    public function getCompanyBaseInfo(int $id)
    {
        return $this->where('id', $id)->first();
    }
}
