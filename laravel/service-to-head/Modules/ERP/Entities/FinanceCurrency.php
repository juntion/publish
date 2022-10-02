<?php

namespace Modules\ERP\Entities;

class FinanceCurrency extends Model
{
    protected $table = 'ns_finance_currencies';

    public function export(): array
    {
        return [];
    }
}
