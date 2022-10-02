<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\NsExpenseVoucherRecordRepository as ContractsNsExpenseVoucherRecordRepository;
use Modules\ERP\Entities\NsExpenseVoucherRecord;


class NsExpenseVoucherRecordRepository implements ContractsNsExpenseVoucherRecordRepository
{
    public static function getVoucherInfoByOrderNumber($orderNumber)
    {
        return NsExpenseVoucherRecord::where([['fs_so_num', $orderNumber], ['fs_is_cancel', '0'], ['fs_products_instock_id', '0'], ['ns_status', '300']])->get();
    }
}