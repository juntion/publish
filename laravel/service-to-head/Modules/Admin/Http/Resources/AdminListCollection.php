<?php

namespace Modules\Admin\Http\Resources;

use Modules\Base\Http\Resources\Json\ResourceCollection;

class AdminListCollection extends ResourceCollection
{
    static public $wrap = "admins";

    public function toArray($request)
    {
        return $this->collection->map(function ($admin) {
            return [
                "uuid" => $admin->uuid,
                "name" => $admin->name
            ];
        })->all();
    }
}