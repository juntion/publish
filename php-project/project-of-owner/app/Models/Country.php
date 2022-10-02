<?php


namespace App\Models;

use App\Models\BaseModel;

class Country extends BaseModel
{
    protected $table = "countries";
    protected $primaryKey = "countries_id";

    public function customer()
    {
        return $this->belongsTo('\App\Models\Customer', "countries_id", 'customer_country_id');
    }
}
