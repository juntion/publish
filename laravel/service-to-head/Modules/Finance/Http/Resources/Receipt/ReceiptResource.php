<?php


namespace Modules\Finance\Http\Resources\Receipt;

use Modules\Base\Http\Resources\Json\Resource;

class ReceiptResource extends Resource
{
    static public $wrap = "receipt";

    public function toArray($request)
    {
        return [
            "uuid"                      => $this->uuid,
            "number"                    => $this->number,
            "transaction_serial_number" => $this->transaction_serial_number,
            "is_match"                  => $this->is_match,
            "currency"                  => $this->currency,
            "amount"                    => $this->amount,
            "fee"                       => $this->fee,
            "fee_fs"                    => $this->fee_fs,
            "float"                     => $this->float,
            "usable"                    => $this->usable,
            "used"                      => $this->used,
            "cleared"                   => $this->cleared,
            "company_uuid"              => $this->company_uuid,
            "company_name"              => $this->company_name,
            "customer_company_number"   => $this->customer_company_number,
            "customer_company_name"     => $this->customer_company_name,
            "customer_number"           => $this->customer_number,
            "customer_debit_account"    => $this->customer_debit_account,
            "company_account_number"    => $this->company_account_number,
            "payer_name"                => $this->payer_name,
            "payer_email"               => $this->payer_email,
            "payment_method_id"         => $this->payment_method_id,
            "payment_method_name"       => $this->payment_method_name,
            "payment_remark"            => $this->payment_remark,
            "payment_time"              => $this->getZoneDatetime($this->payment_time),
            "claim_uuid"                => $this->claim_uuid,
            "claim_name"                => $this->claim_name,
            "claim_status"              => $this->claim_status,
            "claim_type"                => $this->claim_type,
            "claim_time"                => $this->claim_time,
            "create_from"               => $this->create_from,
            "creator_uuid"              => $this->creator_uuid,
            "creator_name"              => $this->creator_name,
            "deleted_at"                => $this->deleted_at,
            "created_at"                => $this->created_at,
            "updated_at"                => $this->updated_at,
            "application"               => $this->application ? new ReceiptApplicationWithoutFilesResource($this->application) : null,
        ];
    }
}
