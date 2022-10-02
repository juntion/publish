<?php

namespace Modules\ERP\Contracts;

interface ProductsInstockShippingPaymentInvoiceRepository
{
    /**
     * @param array $fields
     * @return mixed
     */
    public static function getProductsInstockShippingPaymentInvoiceData(array $fields);
}
