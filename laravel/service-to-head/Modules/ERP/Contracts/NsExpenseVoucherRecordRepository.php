<?php

namespace Modules\ERP\Contracts;


interface NsExpenseVoucherRecordRepository
{
    /**
     * 根据订单FS编号获取支出凭证信息
     */
    public static function getVoucherInfoByOrderNumber($orderNumber);
}