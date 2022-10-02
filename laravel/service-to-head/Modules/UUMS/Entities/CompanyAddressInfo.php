<?php


namespace Modules\UUMS\Entities;



use Illuminate\Support\Str;

class CompanyAddressInfo extends Model
{
    protected $table = "company_address_info";

    public function company()
    {
        return $this->belongsTo(Company::class, "id", "company_id");
    }

    public function export(): array
    {
        return [
            'uuid' => Str::uuid()->getHex()->toString(),
            'id'   => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'country_name' => $this->country  ?? "",
            'province'     => $this->province  ?? "",
            'city'         => $this->city  ?? "",
            'area'         => $this->area ?? "",
            'address'      => $this->address ?? "",
            'postcode'     => $this->postcode ?? "",
            'tel'          => $this->tel ?? "",
            'foreign_name' => $this->name ?? "",
            'foreign_country_name' => $this->en_country ?? "",
            'foreign_province'     => $this->en_province ?? "",
            'foreign_city'         => $this->en_city ?? "",
            'foreign_area'         => $this->en_area ?? "",
            'foreign_address'      => $this->en_address ?? "",
            'foreign_postcode'     => $this->en_postcode ?? "",
            'foreign_tel'          => $this->en_tel ?? "",
            'comment'              => $this->comment ?? "",
            'status'               => $this->status,
            'created_at'           => $this->created_at,
            'updated_at'           => $this->updated_at,
            'company_uuid'         => $this->company_id,
        ];
    }
}
