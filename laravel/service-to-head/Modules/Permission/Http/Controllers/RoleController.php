<?php

namespace Modules\Permission\Http\Controllers;

use Illuminate\Support\Str;
use Modules\Base\Contracts\ListServiceInterface;
use Modules\Permission\Entities\Role;
use Modules\Permission\Http\Requests\RolesRequest;
use Modules\Permission\Http\Requests\CreateRoleRequest;
use Modules\Permission\Http\Requests\EditRoleRequest;
use Modules\Permission\Http\Requests\SyncRolePermissionsRequest;
use Modules\Permission\Http\Requests\RolesPermissionsRequest;
use Modules\Permission\Http\Resources\PermissionCollection;
use Modules\Permission\Http\Resources\AdminCollection;
use Modules\Permission\Http\Resources\RoleResource;
use Modules\Permission\Http\Resources\RoleCollection;

class RoleController extends Controller
{
    public function index(RolesRequest $request, ListServiceInterface $listService)
    {
        $listService->setBuilder(new Role());
        $listService->setRequest($request);

        return new RoleCollection($listService->getResource());
    }

    public function store(CreateRoleRequest $request)
    {
        $role = Role::create([
            'uuid' => Str::uuid()->getHex()->toString(),
            'name' => $request->post('name'),
            'guard_name' => $request->post('guard_name'),
            'locale' => $request->post('locale'),
            'comment' => $request->post('comment') ?: '',
        ])->refresh();

        return new RoleResource($role);
    }

    public function update(EditRoleRequest $request, $uuid)
    {
        $role = Role::find($uuid);

        if (!$role->is_system) {
            if ($role->name != $request->input('name')) {
                $request->validate(['name' => 'unique:roles']);
            }

            $flag = $role->update([
                'name' => $request->input('name'),
                'locale' => $request->input('locale'),
                'comment' => $request->input('comment') ?: ''
            ]);
            return $flag ? new RoleResource($role) : $this->failed();
        }

        return $this->failed();
    }

    public function destroy($uuid)
    {
        $role = Role::find($uuid);
        if (!$role->is_system && $role->delete()) {
            return $this->deleteSuccess();
        }
        return $this->failed();
    }

    public function permissions($uuid)
    {
        $role = Role::find($uuid);
        return new PermissionCollection($role->permissions);
    }

    public function admins($uuid)
    {
        $role = Role::find($uuid);
        return new AdminCollection($role->users);
    }

    public function syncPermissions(SyncRolePermissionsRequest $request, $uuid)
    {
        $role = Role::find($uuid);

        if (!$role->is_system) {
            $role->permissions()->sync($request->input('permissions'));
            return $this->successWithMessage();
        }

        return $this->failed();
    }

    public function rolesPermissions(RolesPermissionsRequest $request)
    {
        $guard = $request->query('filter')['guard_name'];
        $rolesPermissions = Role::with('permissions')->where('guard_name', $guard)->get();
        return $this->successWithData(['roles' => $rolesPermissions]);
    }

}
