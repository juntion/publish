<?php


namespace Modules\Permission\Http\Resources;

use Modules\Base\Http\Resources\Json\Resource;

class RoleResource extends Resource
{
    static public $wrap = "role";

    public function toArray($request)
    {
        return $this->attributesToArray();
    }
}
