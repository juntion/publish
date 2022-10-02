<?php


namespace Modules\Finance\Http\Resources\Invoice;

use Modules\Base\Http\Resources\Json\Resource;

class InvoiceResource extends Resource
{
    /**
     * @var string
     */
    public static $wrap = 'invoice';

    /**
     * @param \Illuminate\Http\Request $request
     * @return array|array[]
     */
    public function toArray($request)
    {
        return [
            "uuid" => $this->uuid,
            "number" => $this->number,
            "type" => $this->type,
            "company_uuid" => $this->company_uuid,
            "company_name" => $this->company_name,
            "customer_company_number" => $this->customer_company_number,
            "customer_company_name" => $this->customer_company_name,
            "customer_number" => $this->customer_number,
            "currency" => $this->currency,
            "amount" => $this->amount,
            "cleared" => $this->cleared,
            "relate_id" => $this->relate_id,
            "to_void" => $this->to_void,
            "origin_uuid" => $this->origin_uuid ?? null
        ];
    }
}
