<?php

namespace App\Repositories\Permission;

use App\Models\Permission\Role;
use App\Repositories\BaseRepository;

class RoleRepository extends BaseRepository
{
    protected $model;

    protected $allowedSearches = ['guard_name', 'name', 'comment', 'locale'];

    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    /**
     * @param Role $role
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getUsers(Role $role)
    {
        $limit = (int)(request()->input('limit', 20));
        return $role->users()->orderBy('id', 'asc')->with('department', 'positions', 'company')->paginate($limit);
    }
}
