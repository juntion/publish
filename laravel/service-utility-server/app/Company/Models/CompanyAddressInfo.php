<?php


namespace App\Company\Models;


use App\Enums\Company\AddressType;
use App\Traits\Company\CompanyStatusLogTrait;
use App\Traits\ModelsTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class CompanyAddressInfo extends Model implements HasMedia
{
    use ModelsTrait,HasMediaTrait, CompanyStatusLogTrait;
    protected $table = "company_address_info";

    protected $fillable = ['name', 'en_name', 'country', 'province', 'city', 'address','area', 'tel', 'en_country', 'en_province', 'en_city', 'en_area', 'en_address', 'en_tel', 'company_id', 'type', 'postcode', 'en_postcode', 'comment', 'status'];

    protected $appends = ['cn_status'];
    public function contacts()
    {
        return $this->hasMany(CompanyAddressContact::class, "address_id", "id");
    }

    public function getMediaCollection ()
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

    public function registerMediaCollections()
    {
        $this->addMediaCollection($this->getMediaCollection())
            ->useDisk('company');
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
