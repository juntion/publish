<?php

namespace Modules\UUMS\Entities;


use Illuminate\Support\Str;

class Company extends Model
{
    protected $table = "companies";

    public function export(): array
    {
        return [
            'id'             => $this->id,
            'uuid'           => Str::uuid()->getHex()->toString(),
            'ns_internal_id' => $this->ns_internal_id,
            'name'           => $this->company_name,
            'foreign_name'   => $this->company_english_name,
            'simple_name'    => $this->company_simple_name,
            'type'           => $this->type,
            'p_id'           => $this->p_id,
            'code'           => $this->main_tag,
            'country_name'   => $this->country,
            'contacts'       => $this->contacts,
            'profile'        => $this->profile,
            'is_show'        => $this->is_show,
            'status'         => $this->status,
            'time_zone'      => $this->time_zone,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at
        ];
    }
}
