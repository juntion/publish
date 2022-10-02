<?php


namespace Modules\Route\Http\Resources;

use Modules\Base\Http\Resources\Json\ResourceCollection;

class RouteCollection extends ResourceCollection
{
    static public $wrap = "routes";

    public function toArray($request)
    {
        return $this->collection->map(function ($route) {
            return $route->attributesToArray();
        })->all();
    }
}
