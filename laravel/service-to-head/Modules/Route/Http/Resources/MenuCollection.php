<?php


namespace Modules\Route\Http\Resources;

use Modules\Base\Http\Resources\Json\ResourceCollection;

class MenuCollection extends ResourceCollection
{
    static public $wrap = "menus";

    public function toArray($request)
    {
        return $this->collection->map(function ($menu) {
            return $menu->attributesToArray();
        })->all();
    }
}
