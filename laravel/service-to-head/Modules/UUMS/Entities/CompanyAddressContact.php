<?php


namespace Modules\UUMS\Entities;


use Illuminate\Support\Str;

class CompanyAddressContact extends Model
{

    protected $table = "company_address_contacts";

    public function export(): array
    {
        return [
            'id' => $this->id,
            'uuid' => Str::uuid()->getHex()->toString(),
            'name' => $this->contacts ?? "",
            'tel'  => $this->tel ?? "",
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'address_id' => $this->address_id
        ];
    }
}
