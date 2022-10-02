<?php


namespace App\Company\Observers;


use App\Company\Models\CompanyAddressInfo;

class CompanyAddressInfoObserver
{
    public function created(CompanyAddressInfo $companyAddressInfo)
    {
        $companyAddressInfo->createStatusLog(null, 1);
    }


    public function updated(CompanyAddressInfo $companyAddressInfo)
    {
        if($companyAddressInfo->isDirty("status")){
            $companyAddressInfo->createStatusLog($companyAddressInfo->getOriginal('status'), $companyAddressInfo->status);
        }
    }
}
