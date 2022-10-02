<?php


namespace Modules\Base\Entities\Company;


use Modules\Base\Entities\Model;

class CompanyTaxInfo extends Model
{
    protected $table = "company_tax_info";

    protected $fillable = ['company_uuid', 'country_code', 'country_name', 'tax_number', 'uuid', 'created_at', 'updated_at'];
}
