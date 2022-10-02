<?php


namespace Modules\Base\Repositories\Company;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Base\Entities\Company\Company;
use Modules\Base\Entities\Company\CompanyBank;
use Modules\Base\Repositories\Company\Traits\UploadTrait;
use Prettus\Repository\Eloquent\BaseRepository;
use Modules\Base\Contracts\Company\BankRepository as ContractsBankRepository;

class BankRepository extends BaseRepository implements ContractsBankRepository
{
    use UploadTrait;

    public function model()
    {
       return CompanyBank::class;
    }

    public function getStatusLogs(CompanyBank $companyBank)
    {
        return $companyBank->logs();
    }

    public function updateStatus(CompanyBank $companyBank)
    {
        $status = $companyBank->status == 1 ? 0 : 1;
        $companyBank->update([
           'status' => $status
        ]);
        return true;
    }

    /**
     * @param  Request  $request
     * @param  Company  $company
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(Company $company, array $bankData)
    {
        $bank = $company->banks()->create($bankData);
        return $bank;
    }

    /**
     * @param  Request  $request
     * @param  CompanyBank  $companyBank
     * @return CompanyBank
     */
    public function updateBank(CompanyBank $companyBank, array $bankData)
    {

        $companyBank->update($bankData);
        return $companyBank;
    }

    public function storeAccountInfo(CompanyBank $companyBank, array $accountInfo)
    {
        $accountInfo['uuid'] = Str::uuid()->getHex()->toString();
        $companyBank->bankAccount()->create($accountInfo);
    }

    public function deleteAccountInfo(CompanyBank $companyBank, array $uuids)
    {
        if (!empty($uuids)) {
            $companyBank->bankAccount()->whereNotIn('uuid', $uuids)->delete();
        }else {
            $companyBank->bankAccount()->delete();
        }
    }

    public function updateAccountInfo(CompanyBank $companyBank, array $accountInfo)
    {
        $account = $companyBank->bankAccount()->find($accountInfo['uuid']);
        if(!is_null($account)) {
            $account->update($accountInfo);
        }
    }
}
