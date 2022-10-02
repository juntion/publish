<?php

namespace Modules\ERP\Entities;


class Customer extends Model
{
    protected $table = "customers";

    protected $primaryKey = "customers_id";

    public function export(): array
    {
        return [];
    }
}