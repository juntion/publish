<?php

namespace Modules\Finance\Entities;

use Modules\Base\Entities\Model;

class InvoiceToReceipts extends Model
{
    /**
     * @var string
     */
    protected $table = 'f_invoices_to_receipts';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $guarded = [];
}
