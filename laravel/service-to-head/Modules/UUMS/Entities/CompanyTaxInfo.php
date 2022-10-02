<?php


namespace Modules\UUMS\Entities;


use Illuminate\Support\Str;

class CompanyTaxInfo extends Model
{
    protected $table = "company_tax_info";

    public function export(): array
    {
        $data = $this->toArray();
        $data['uuid'] = Str::uuid()->getHex()->toString();
        $data['country_name'] = $this->country;
        return $data;
    }
}
