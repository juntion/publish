<?php

namespace App\Repositories\Permission;

use App\Models\Permission\Permission;
use App\Repositories\BaseRepository;

class PermissionRepository extends BaseRepository
{
    protected $model;

    protected $allowedSearches = ['name', 'guard_name', 'comment', 'locale'];

    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }
}