<?php


namespace Modules\Base\Entities\Company;


use Modules\Base\Entities\Model;

class CompanyAddressContact extends Model
{
    protected $table = "company_address_contacts";

    protected $fillable = ['company_address_uuid', 'type', 'name', 'tel', 'uuid', 'created_at', 'updated_at'];

}
