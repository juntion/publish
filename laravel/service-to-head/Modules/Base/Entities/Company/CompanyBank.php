<?php


namespace Modules\Base\Entities\Company;


use Modules\Base\Entities\Company\Traits\CompanyStatusLogTrait;
use Modules\Base\Entities\Company\Traits\MediaTrait;
use Modules\Base\Entities\Model;

class CompanyBank extends Model
{
    use CompanyStatusLogTrait, MediaTrait;
    protected $table = "company_banks";

    protected $appends = ['cn_status'];

    protected $fillable = ['company_uuid', 'pay_method', 'status', 'comment', 'check_address', 'bank_name', 'other_info', 'account_name', 'uuid', 'created_at', 'updated_at'];


    public function bankAccount()
    {
        return $this->hasMany(CompanyBankAccount::class, "company_bank_uuid", "uuid");
    }

    public function getMediaCollection()
    {
        return "bank";
    }

    public function getCnStatusAttribute()
    {
        return $this->getStatus($this->status);
    }

    public function getStatus($status)
    {
        switch ($status) {
            case 1:
                return __("base::company.inOperation");
            case 0:
                return __("base::company.hasBeenCancelled");
            default:
                return __("base::company.unknowStatus");
        }
    }
}
