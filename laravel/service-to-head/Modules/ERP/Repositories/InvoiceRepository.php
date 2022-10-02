<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\InvoiceRepository as InvoiceMain;
use Modules\ERP\Entities\Invoice;

class InvoiceRepository implements InvoiceMain
{

    /**
     * @param string $invoice_number
     * @return mixed
     */
    public static function getProductsInvoice(string $invoice_number = 'IN000000000000')
    {
        return Invoice::where('in_number', $invoice_number)->first();
    }
    /**
     * @param int $relateId
     * @param int $type
     * @return mixed
     */
    public static function findProductsInvoice(int $relateId, int $type)
    {
        $fields = [
            'relate_id' => $relateId,
            'type' => $type,
        ];
        return Invoice::where($fields)->first();
    }
}
