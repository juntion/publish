<?php

namespace Modules\Route\Entities\Traits;

trait PermissionToRoute
{
    /**
     * 一个权限对应一个入口
     */
    public function route()
    {
        return $this->hasOne('Modules\Route\Entities\Route', 'uuid', 'uuid');
    }
}
