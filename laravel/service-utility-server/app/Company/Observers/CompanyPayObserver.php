<?php


namespace App\Company\Observers;


use App\Company\Models\Company;
use App\Company\Models\CompanyPay;

class CompanyPayObserver
{
    public function created(CompanyPay $companyPay)
    {
        $companyPay->createStatusLog(null, 1);
    }

    public function updated(CompanyPay $companyPay)
    {
        if($companyPay->isDirty("status")){
            $companyPay->createStatusLog($companyPay->getOriginal('status'), $companyPay->status);
        }
    }
}
