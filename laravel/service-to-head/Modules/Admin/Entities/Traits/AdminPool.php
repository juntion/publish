<?php

namespace Modules\Admin\Entities\Traits;

use Modules\Admin\Entities\Admin;

trait AdminPool
{
    private $adminPool = [];

    public function getAdminNameByUuid($uuid)
    {
        if (!$uuid) return $uuid;

        $admin = $this->getAdminByUuid($uuid);
        return $admin ? $admin->name : $uuid;
    }

    public function getAdminByUuid($uuid)
    {
        if (!$uuid) return $uuid;

        if (!array_key_exists($uuid, $this->adminPool)) {
            $this->adminPool[$uuid] = Admin::find($uuid);
        }

        return $this->adminPool[$uuid];
    }
}
