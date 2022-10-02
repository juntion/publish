<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\OrderPIRepository as ContractsOrderPIRepository;
use Modules\ERP\Entities\ManageCustomerInquiryPIInfo;


class OrderPIRepository implements ContractsOrderPIRepository
{
    public static function getOrderInfoByOrderNumber($orderNumber)
    {
        return ManageCustomerInquiryPIInfo::where('order_invoice', $orderNumber)->first();
    }

    public static function getAllOrderByOrderNumber($orderNumber)
    {
        return ManageCustomerInquiryPIInfo::where('order_invoice', $orderNumber)->get();
    }

    public static function getOrderProductInfo(ManageCustomerInquiryPIInfo $customerInquiryPIInfo)
    {
        return ManageCustomerInquiryPIInfo::with(['piProducts'])->where('id', $customerInquiryPIInfo->id)->get();
    }
}