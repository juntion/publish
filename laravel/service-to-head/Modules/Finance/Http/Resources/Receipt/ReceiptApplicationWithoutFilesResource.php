<?php


namespace Modules\Finance\Http\Resources\Receipt;


use Modules\Base\Http\Resources\Json\Resource;

class ReceiptApplicationWithoutFilesResource extends Resource
{
    public function toArray($request)
    {
        return [
            "uuid"         => $this->uuid,
            "apply_uuid"   => $this->apply_uuid,
            "apply_name"   => $this->apply_name,
            "apply_type"   => $this->apply_type,
            "apply_remark" => $this->apply_remark,
            "check_uuid"   => $this->check_uuid,
            "check_name"   => $this->check_name,
            "check_status" => $this->check_status,
            "check_remark" => $this->check_remark,
            "check_time"   => $this->getZoneDatetime($this->check_time),
            "created_at"   => $this->created_at,
            "updated_at"   => $this->updated_at
        ];
    }
}
