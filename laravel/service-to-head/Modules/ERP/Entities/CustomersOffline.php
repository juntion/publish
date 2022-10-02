<?php

namespace Modules\ERP\Entities;


class CustomersOffline extends Model
{
    protected $table = "customers_offline";

    protected $primaryKey = "customers_id";

    public function export(): array
    {
        return [];
    }
}