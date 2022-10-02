<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\ErpReceiptRepository as ContractsErpReceiptRepository;
use Modules\ERP\Entities\ProductsInstockShippingApply;

class ErpReceiptRepository implements ContractsErpReceiptRepository
{

    /**
     * 退款记录
     * @param string $number
     * @return mixed
     */
    public function getRefunds(string $number)
    {
        return ProductsInstockShippingApply::query()
            ->where('apply_type', '=', '7')
            ->whereIn('status', [0, 1, 2, 3, 6])
            ->where('DK_number', '=', $number)
            ->with(['user', 'paymentMethod', 'currency'])
            ->get();
    }

    /**
     * 手续费用申请记录
     * @param string $number
     * @return mixed
     */
    public function getFees(string $number)
    {
        return $this->getDkApply($number, 8, 0);
    }

    /**
     * 汇率浮动,币种转换单
     * @param string $number
     * @return mixed
     */
    public function getFloats(string $number)
    {
        return $this->getDkApply($number, 22, 0);
    }

    /**
     * 垫付申请
     * @param array $instock_id
     * @return mixed
     */
    public function getPrepays(array $instock_id)
    {
        return ProductsInstockShippingApply::with(['uniqueNumber'])
            ->select(
                'id',
                'orders_num',
                'apply_time',
                'apply_admin',
                'DK_number',
                'currencies_id',
                'apply_money',
                'status'
                )
            ->where([['is_delete', '!=', '1'], 'apply_type' => 3, 'is_advance' => 27, 'is_fillmoney' => 0])
            ->whereIn('products_instock_id', $instock_id)
            ->get();
    }

    /**
     * 获取DK类申请
     * @param string $number
     * @param $is_advance
     * @param $is_fillmoney
     * @return mixed
     */
    public function getDkApply(string $number, $is_advance, $is_fillmoney)
    {
        return ProductsInstockShippingApply::with(['uniqueNumber'])
            ->select(
            'id',
            'apply_time',
            'apply_admin',
            'orders_num',
            'DK_number',
            'currencies_id',
            'apply_money',
            'is_yf',
            'status'
            )
            ->where([['is_delete', '!=', '1'], 'apply_type' => 3, 'is_advance' => $is_advance, 'is_fillmoney' => $is_fillmoney, 'DK_number' => $number])
            ->get();
    }
}
