<?php


namespace App\Company\Models;


use App\Traits\Company\CompanyStatusLogTrait;
use App\Traits\ModelsTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class CompanyPay extends Model implements HasMedia
{
    use ModelsTrait,HasMediaTrait, CompanyStatusLogTrait;
    protected $table = "company_pay";

    protected $appends = ['cn_status'];

    protected $fillable = ['company_id', 'pay_method', 'status', 'comment', 'check_address', 'bank_name', 'other_info', 'account_name'];


    public function accountInfos()
    {
        return $this->hasMany(CompanyPayAccountInfo::class, "pay_id", "id");
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
        switch ($status){
            case 1:
                return "运营中";
            case 0:
                return "已注销";
            default:
                return "未知状态";
        }
    }
}
