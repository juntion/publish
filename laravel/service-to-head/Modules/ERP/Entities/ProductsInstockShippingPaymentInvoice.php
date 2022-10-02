<?php

namespace Modules\ERP\Entities;

class ProductsInstockShippingPaymentInvoice extends Model
{

    /**
     * @var string
     */
    protected $table = 'products_instock_shipping_payment_invoice';

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
