<?php

namespace Modules\Base\Http\Resources;

use Modules\Base\Http\Resources\Json\ResourceCollection;

class OpenAuthCollection extends ResourceCollection
{
    static public $wrap = "token_list";
    
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                "access_key_id" => $item->access_key_id,
                "access_key_secret" => $item->access_key_secret,
                "exp_time" => $item->exp_time,
                "status" => $item->status,
                "remarks" => $item->remarks,
                "created_at" => $item->created_at,
                "updated_at" => $item->updated_at
            ];
        })->all();
    }
}