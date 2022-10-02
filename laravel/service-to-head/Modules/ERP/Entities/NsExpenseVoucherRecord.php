<?php

namespace Modules\ERP\Entities;


class NsExpenseVoucherRecord extends Model
{
    protected $table = "ns_expense_voucher_record";

    protected $primaryKey = "fs_id";

    public function export(): array
    {
        return [];
    }
}