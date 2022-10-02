<?php

namespace App\Models;

class Currency extends BaseModel
{
    public $currencies = [];
    protected $table='currencies';

    public function getAllCurrency()
    {
        return $this->all();
    }
}
