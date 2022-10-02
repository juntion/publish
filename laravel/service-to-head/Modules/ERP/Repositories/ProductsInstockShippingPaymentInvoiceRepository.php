<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\ProductsInstockShippingPaymentInvoiceRepository as ProductsInstockShippingPaymentInvoiceMain;
use Modules\ERP\Entities\ProductsInstockShippingPaymentInvoice as ProductsInstockShippingPaymentInvoiceModel;

class ProductsInstockShippingPaymentInvoiceRepository implements ProductsInstockShippingPaymentInvoiceMain
{
    /**
     * @param array $fields
     * @return mixed
     */
    public static function getProductsInstockShippingPaymentInvoiceData(array $fields)
    {
        return ProductsInstockShippingPaymentInvoiceModel::where($fields)->orderByDesc('id')->get();
    }
}
