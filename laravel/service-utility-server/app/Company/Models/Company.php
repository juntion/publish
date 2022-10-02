<?php

namespace App\Company\Models;

use App\Enums\Company\AddressType;
use App\Traits\Company\CompanyStatusLogTrait;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use CompanyStatusLogTrait;

    public $Media = 'company';
    protected $fillable =['type', "company_simple_name", "main_tag", "company_name", "company_english_name", "time_zone", "profile", "is_show", "status", "contacts", "p_id", "country"];

    protected $appends = ['cn_status'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->number) {
                $model->number = static::findAvailableNumber();
                if (!$model->number) {
                    return false;
                }
            }
        });
    }

    static public function findAvailableNumber()
    {
        for ($i = 0; $i < 10; $i++) {
            $lastTask = static::query()->orderBy('id', 'desc')->first();
            if ($lastTask) {
                $no = $lastTask->number + 1;
            } else {
                $no = 1;
            }
            if ($no < 10) {
                $no = "0" . $no;
            }
            // 判断编号是否存在
            if (!self::query()->where('number', $no)->exists()) {
                return $no;
            }
        }
        logger()->warning('生成编号失败');
        return false;
    }

    public function taxInfo()
    {
        return $this->hasMany(CompanyTaxInfo::class, "company_id", "id");
    }

    public function address()
    {
        return $this->hasOne(CompanyAddressInfo::class, "company_id", "id")->where("type",AddressType::REGISTER_TYPE);
    }

    public function office()
    {
        return $this->hasMany(CompanyAddressInfo::class, "company_id", "id")->where("type", AddressType::OFFICE_TYPE);
    }

    public function warehouse()
    {
        return $this->hasMany(CompanyAddressInfo::class, "company_id", "id")->where("type", AddressType::WAREHOUSE_TYPE);
    }

    public function banks()
    {
        return $this->hasMany(CompanyPay::class, "company_id", "id");
    }

    public function getCnStatusAttribute()
    {
        return $this->getStatus($this->status);
    }

    public function child()
    {
        return $this->hasMany(Company::class, 'p_id', 'id')
            ->where('type',2)
            ->select("id", "p_id", "company_simple_name");
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
