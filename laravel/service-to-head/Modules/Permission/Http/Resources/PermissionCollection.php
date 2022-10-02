<?php


namespace Modules\Permission\Http\Resources;

use Modules\Base\Http\Resources\Json\ResourceCollection;

class PermissionCollection extends ResourceCollection
{
    static public $wrap = "permissions";

    public function toArray($request)
    {
        return $this->collection->map(function ($p) {
            return [
                "uuid" => $p->uuid,
                "name" => $p->name,
                "guard_name" => $p->guard_name,
                "type" => $p->type,
                "group" => $p->group,
                "locale" => $p->locale,
                "comment" => $p->comment,
                "created_at" => $p->created_at,
                "updated_at" => $p->updated_at
            ];
        })->all();
    }
}
