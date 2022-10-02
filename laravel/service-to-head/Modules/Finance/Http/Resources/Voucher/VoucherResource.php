<?php


namespace Modules\Finance\Http\Resources\Voucher;

use Modules\Base\Http\Resources\Json\Resource;

class VoucherResource extends Resource
{
    static public $wrap = "voucher";

    public function toArray($request)
    {
        return [
            "uuid"         => $this->uuid,
            "number"       => $this->number,
            "currency"     => $this->currency,
            "usable"       => $this->usable,
            "used"         => $this->used,
            "type"         => $this->type,
            "order_number" => $this->order_number,
            "remark"       => $this->remark,
            "creator_uuid" => $this->creator_uuid,
            "creator_name" => $this->creator_name,
            "deleted_at"   => $this->getZoneDatetime($this->deleted_at),
            "created_at"   => $this->created_at,
            "updated_at"   => $this->updated_at,
        ];
    }
}
