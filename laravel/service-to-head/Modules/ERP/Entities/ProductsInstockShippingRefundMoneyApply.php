<?php

namespace Modules\ERP\Entities;

class ProductsInstockShippingRefundMoneyApply extends Model
{
    /**
     * @var string
     */
    protected $table = 'products_instock_shipping_refund_money_apply';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @return array
     */
    public function export(): array
    {
        return [];
    }
}
