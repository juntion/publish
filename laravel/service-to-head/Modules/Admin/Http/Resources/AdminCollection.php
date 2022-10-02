<?php


namespace Modules\Admin\Http\Resources;

use Modules\Base\Http\Resources\Json\ResourceCollection;

class AdminCollection extends ResourceCollection
{
    static public $wrap = "admins";

    public function toArray($request)
    {
        return $this->collection->map(function ($admin) {
            return [
                "uuid" => $admin->uuid,
                "group_uuid" => $admin->group_uuid,
                "name" => $admin->name,
                "email" => $admin->email,
                "avatar" => $admin->avatar,
                "created_at" => $admin->created_at,
                "updated_at" => $admin->updated_at
            ];
        })->all();
    }
}
