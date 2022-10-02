<?php

namespace Modules\Permission\Entities;

use Modules\Base\Entities\Model;
use Modules\Base\Support\CacheAble\ModelCache;
use Modules\Route\Entities\Traits\PermissionToRoute;

class Permission extends Model
{
    use ModelCache, PermissionToRoute;

    protected $guarded = [];

    protected $casts = [
        'locale' => 'json',
    ];
}
