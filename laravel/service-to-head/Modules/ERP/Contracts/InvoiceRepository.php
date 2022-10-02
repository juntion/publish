<?php

namespace Modules\ERP\Contracts;

interface InvoiceRepository
{

    /**
     * @param string $invoice_number
     * @return mixed
     */
    public static function getProductsInvoice(string $invoice_number = 'IN000000000000');

    /**
     * @param int $relateId
     * @param int $type
     * @return mixed
     */
    public static function findProductsInvoice(int $relateId, int $type);
}
