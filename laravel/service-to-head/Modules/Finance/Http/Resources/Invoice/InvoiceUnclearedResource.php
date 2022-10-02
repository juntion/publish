<?php


namespace Modules\Finance\Http\Resources\Invoice;


use Modules\Base\Http\Resources\Json\ResourceCollection;

class InvoiceUnclearedResource extends ResourceCollection
{
    public static $wrap = 'invoices';

    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return self::toInvoiceDetail($item);
        })->all();
    }

    public function toInvoiceDetail($item)
    {
        return [
            'uuid'           => $item->uuid,
            'number'         => $item->number,
            'type'           => $item->type,
            'assistant_uuid' => $item->assistant_uuid,
            'assistant_name' => $item->assistant_name,
            'currency'       => $item->currency,
            'amount'         => $item->amount,
            'cleared'        => $item->cleared,
            'cleared_status' => $item->cleared_status,
            'to_void'        => $item->to_void,
            'relate_id'      => $item->relate_id,
            'created_at'      => $item->created_at,
        ];
    }
}
