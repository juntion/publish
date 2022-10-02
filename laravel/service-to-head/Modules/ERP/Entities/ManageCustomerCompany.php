<?php


namespace Modules\ERP\Entities;

use Illuminate\Support\Str;

class ManageCustomerCompany extends Model
{
    protected $table = 'manage_customer_company';

    protected $primaryKey = "id";

    public function export(): array
    {
        return [
            'id'                => $this->id,
            'uuid'              => Str::uuid()->getHex()->toString(),
            'company_number'    => $this->company_number,
            'customers_company' =>$this->customers_company,
            'ns_internal_id'    =>$this->ns_internal_id
        ];
    }

    public function company()
    {
        return $this->belongsTo(CompanyOfCustomer::class, 'company_number', 'company_number');
    }
}
