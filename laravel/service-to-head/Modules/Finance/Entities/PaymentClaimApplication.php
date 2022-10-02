<?php


namespace Modules\Finance\Entities;


use Modules\Base\Entities\Model;

class PaymentClaimApplication extends Model
{
    protected $table = 'f_payment_claim_applications';

   // protected $guarded = [];

    protected $fillable = ['uuid', 'receipt_uuid', 'customer_company_number', 'customer_number', 'apply_uuid', 'apply_name', 'apply_type', 'apply_remark', 'check_uuid', 'check_name', 'check_status', 'check_remark', 'check_time'];

    public function getMediaCollection()
    {
        return "claimApplication";
    }

    public function media()
    {
        return $this->hasMany(PaymentClaimApplyFile::class, 'apply_uuid', 'uuid');
    }
}
