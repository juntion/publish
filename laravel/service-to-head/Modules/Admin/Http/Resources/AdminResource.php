<?php


namespace Modules\Admin\Http\Resources;

use Modules\Base\Http\Resources\Json\Resource;

class AdminResource extends Resource
{
    static public $wrap = "admin";

    public function toArray($request)
    {
        return [
            "uuid" => $this->uuid,
            "group_uuid" => $this->group_uuid,
            "name" => $this->name,
            "email" => $this->email,
            "avatar" => $this->avatar,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
