<?php


namespace Modules\Route\Http\Resources;

use Modules\Base\Http\Resources\Json\Resource;

class MenuResource extends Resource
{
    static public $wrap = "menu";

    public function toArray($request)
    {
        return $this->attributesToArray();
    }
}
