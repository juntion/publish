<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\OrderOffsetInfosRepository as OrderOffsetInfosRepositoryMain;
use Modules\ERP\Entities\ProductsInstockShippingRefundMoneyApply;
use Modules\ERP\Entities\ProductsInstockShippingSalesAfter;
use Modules\ERP\Entities\ProductsInstockShippingApply;

class OrderOffsetInfosRepository implements OrderOffsetInfosRepositoryMain
{

    /**
     * @param array $ids
     * @return mixed
     */
    public function getOrderCreditRefund(array $ids)
    {
        $credit = ProductsInstockShippingRefundMoneyApply::where('ns_internal_id', '>','0')
            ->whereIn('products_instock_id', $ids)
            ->get()
            ->toArray();
        return $credit;
    }
    /**
     * @param array $ids
     * @return mixed
     */
    public function getOrderCreditAfter(array $ids)
    {
        $credit = ProductsInstockShippingSalesAfter::query()
            ->where(function ($q){
                $q->where('ns_credit_note_id', '>','0')
                    ->orWhere('ns_credit_note_id', '!=', '');
            })
            ->where('ns_credit_note_id', '!=', '0')
            ->whereIn('products_instock_id', $ids)
            ->get()
            ->toArray();
        return $credit;
    }
    /**
     * @param array $ids
     * @return mixed
     */
    public function getOrderConcession(array $ids)
    {
        $whereArr = [
            ['apply_type', '=', 3],
            ['is_fillmoney', '=', 0],
            ['status', '=', 1],
        ];
        $concession = ProductsInstockShippingApply::query()
            ->where($whereArr)
            ->whereIn('products_instock_id', $ids)
            ->whereIn('is_advance', [13, 14, 15, 23, 24])
            ->orderBy('is_advance', 'desc')
            ->with('uniqueNumber')
            ->with('child')
            //->whereDoesntHave('child')
            ->get()
            ->toArray();
        return $concession;
    }
}
