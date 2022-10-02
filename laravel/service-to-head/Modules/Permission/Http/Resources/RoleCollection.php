<?php


namespace Modules\Permission\Http\Resources;

use Modules\Base\Http\Resources\Json\ResourceCollection;

class RoleCollection extends ResourceCollection
{
    static public $wrap = "roles";

    public function toArray($request)
    {
        return $this->collection->map(function ($role) {
            return $role->attributesToArray();
        })->all();
    }
}
