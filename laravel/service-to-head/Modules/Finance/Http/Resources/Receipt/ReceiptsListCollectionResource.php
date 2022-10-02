<?php


namespace Modules\Finance\Http\Resources\Receipt;


use Modules\Base\Http\Resources\Json\ResourceCollection;

class ReceiptsListCollectionResource extends ResourceCollection
{
    public static $wrap = 'receipts';

    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                "uuid"                      => $item->uuid,
                "number"                    => $item->number,
                "transaction_serial_number" => $item->transaction_serial_number,
                "is_match"                  => $item->is_match,
                "currency"                  => $item->currency,
                "amount"                    => $item->amount,
                "fee"                       => $item->fee,
                "fee_fs"                    => $item->fee_fs,
                "float"                     => $item->float,
                "usable"                    => $item->usable,
                "used"                      => $item->used,
                "cleared"                   => $item->cleared,
                "company_uuid"              => $item->company_uuid,
                "company_name"              => $item->company_name,
                "company_account_number"    => $item->company_account_number,
                "customer_company_number"   => $item->customer_company_number,
                "customer_company_name"     => $item->customer_company_name,
                "customer_number"           => $item->customer_number,
                "customer_debit_account"    => $item->customer_debit_account,
                "payer_name"                => $item->payer_name,
                "payer_email"               => $item->payer_email,
                "payment_method_id"         => $item->payment_method_id,
                "payment_method_name"       => $item->payment_method_name,
                "payment_remark"            => $item->payment_remark,
                "payment_time"              => $this->getZoneDatetime($item->payment_time),
                "claim_uuid"                => $item->claim_uuid,
                "claim_name"                => $item->claim_name,
                "claim_status"              => $item->claim_status,
                "claim_type"                => $item->claim_type,
                "claim_time"                => $this->getZoneDatetime($item->claim_time),
                "create_from"               => $item->create_from,
                "creator_uuid"              => $item->creator_uuid,
                "creator_name"              => $item->creator_name,
                "deleted_at"                => $item->deleted_at,
                "created_at"                => $item->created_at,
                "updated_at"                => $item->updated_at,
                "application"               => $item->application ? new ReceiptApplication($item->application) : null,
            ];
        })->all();
    }
}
