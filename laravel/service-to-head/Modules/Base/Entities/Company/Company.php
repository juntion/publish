<?php

namespace Modules\Base\Entities\Company;

use Modules\Base\Entities\Company\Traits\CompanyStatusLogTrait;
use Modules\Base\Entities\Model;
use Modules\Base\Enums\Company\AddressType;

class Company extends Model
{
    use CompanyStatusLogTrait;

    public $Media = 'company';

    protected $fillable = [
            'type', "simple_name", "code", "name", "country_code", "foreign_name", "time_zone", "profile", "is_show",
            "status", "contacts", "parent_uuid", 'uuid', 'one_level_uuid', 'two_level_uuid', 'country_name',
            'created_at', 'updated_at'
        ];

    protected $appends = ['cn_status'];

    // 之前数据id => number 后续数据 返回id
    protected $numberMap
        = [
            1 => '04',
            2 => '09',
            3 => '10',
            4 => '05',
            5 => '07',
            6 => '06',
            7 => '08',
            8 => '02',
            9 => '03',
            10 => '01',
            11 => '11',
            12 => '12'
        ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = static::findAvailableNumber();
                if (!$model->id) {
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
            if (!self::query()->where('id', $no)->exists()) {
                return $no;
            }
        }
        logger()->warning('生成编号失败');
        return false;
    }

    public function taxInfo()
    {
        return $this->hasMany(CompanyTaxInfo::class, "company_uuid", "uuid");
    }

    public function address()
    {
        return $this->hasOne(CompanyAddress::class, "company_uuid", "uuid")->where("type", AddressType::REGISTER_TYPE);
    }

    public function office()
    {
        return $this->hasMany(CompanyAddress::class, "company_uuid", "uuid")->where("type", AddressType::OFFICE_TYPE);
    }

    public function warehouse()
    {
        return $this->hasMany(CompanyAddress::class, "company_uuid", "uuid")->where("type", AddressType::WAREHOUSE_TYPE);
    }

    public function banks()
    {
        return $this->hasMany(CompanyBank::class, "company_uuid", "uuid");
    }

    public function getCnStatusAttribute()
    {
        return $this->getStatus($this->status);
    }

    public function child()
    {
        return $this->hasMany(Company::class, 'parent_uuid', 'uuid')
            ->where('type', 2)
            ->select("uuid", "parent_uuid", "simple_name");
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

    public function getNumberAttribute()
    {
        if (isset($this->numberMap[$this->id])) {
            return $this->numberMap[$this->id];
        }
        return $this->id;
    }
}
