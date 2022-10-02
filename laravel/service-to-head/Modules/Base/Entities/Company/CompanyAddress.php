<?php


namespace Modules\Base\Entities\Company;


use Modules\Base\Entities\Company\Traits\MediaTrait;
use Modules\Base\Enums\Company\AddressType;
use Modules\Base\Entities\Company\Traits\CompanyStatusLogTrait;
use Modules\Base\Entities\Model;

class CompanyAddress extends Model
{
    use CompanyStatusLogTrait, MediaTrait;
    protected $table = "company_addresses";

    protected $fillable = ['name', 'foreign_name', 'country_code', 'country_name', 'province', 'city', 'address','area', 'tel', 'foreign_country_name', 'foreign_country_code', 'foreign_province', 'foreign_city', 'foreign_area', 'foreign_address', 'foreign_tel', 'company_uuid', 'type', 'postcode', 'foreign_postcode', 'comment', 'status', 'uuid', 'created_at', 'updated_at'];

    protected $appends = ['cn_status'];

    public function allContacts()
    {
        return $this->hasMany(CompanyAddressContact::class, "company_address_uuid", "uuid");
    }

    public function contacts()
    {
        return $this->hasMany(CompanyAddressContact::class, "company_address_uuid", "uuid")->where('type', 1);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, "company_uuid", "uuid");
    }

    public function foreignContacts()
    {
        return $this->hasMany(CompanyAddressContact::class, "company_address_uuid", "uuid")->where('type', 2);
    }

    public function getMediaCollection()
    {
        switch ($this->type){
            case AddressType::REGISTER_TYPE:
                return "register_info";
            case AddressType::OFFICE_TYPE:
                return "office";
            case AddressType::WAREHOUSE_TYPE:
                return "warehouse";
            default:
                return "register_info";
        }
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
