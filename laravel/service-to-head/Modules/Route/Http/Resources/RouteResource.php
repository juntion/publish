<?php


namespace Modules\Route\Http\Resources;

use Modules\Base\Http\Resources\Json\Resource;

class RouteResource extends Resource
{
    static public $wrap = "route";

    public function toArray($request)
    {
        return $this->attributesToArray();
    }
}
