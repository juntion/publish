<?php


namespace App\Company\Observers;


use App\Company\Models\Company;

class CompanyObserver
{
    public function created(Company $company)
    {
        $company->createStatusLog(null, 1);
    }


    public function updated(Company $company)
    {
        if($company->isDirty("status")){
            $company->createStatusLog($company->getOriginal('status'), $company->status);
        }
    }
}
