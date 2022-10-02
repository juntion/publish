<?php


namespace Modules\Permission\Http\Resources;

use Modules\Base\Http\Resources\Json\Resource;

class PermissionResource extends Resource
{
    static public $wrap = "permission";

    public function toArray($request)
    {
        return $this->attributesToArray();
    }
}
