<?php

namespace Modules\Permission\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Base\Criteria\ListRequestCriteria;
use Modules\Permission\Contracts\PermissionRepository;
use Modules\Permission\Http\Requests\PermissionsRequest;
use Modules\Permission\Http\Requests\GroupsRequest;
use Modules\Permission\Entities\PermissionGroup;
use Modules\Permission\Http\Resources\PermissionCollection;

class PermissionController extends Controller
{
    use PermissionGroup;

    public function fetchPermission(Request $request, PermissionRepository $permissionRepository)
    {
        return new PermissionCollection($permissionRepository->getUserAllPermissions($request->user()));
    }

    public function index(PermissionsRequest $request, PermissionRepository $permissionRepository)
    {
        $permissionRepository->pushCriteria(new ListRequestCriteria($request));

        return new PermissionCollection($permissionRepository->paginate($request->query('limit')));
    }

    public function groups(GroupsRequest $request, PermissionRepository $permissionRepository)
    {
        $guard = $request->query('filter')['guard_name'];

        return $this->successWithData(['groups' => $permissionRepository->getGroupPermissionsByGuard($guard)]);
    }
}
