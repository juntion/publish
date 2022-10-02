<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Str;
use Modules\Base\Criteria\ListRequestCriteria;
use Modules\Permission\Contracts\PermissionRepository;
use Modules\Admin\Contracts\AdminRepository;
use Modules\Admin\Entities\Admin;
use Modules\Admin\Http\Requests\AdminsRequest;
use Modules\Admin\Http\Requests\CreateAdminRequest;
use Modules\Admin\Http\Requests\EditAdminRequest;
use Modules\Admin\Http\Requests\SyncAdminRolesPermissionsRequest;
use Modules\Admin\Notifications\CreateAdmin as CreateAdminNotification;
use Modules\Admin\Notifications\UpdateAdmin as UpdateAdminNotification;
use Modules\Admin\Http\Resources\AdminResource;
use Modules\Admin\Http\Resources\AdminCollection;
use Modules\Admin\Http\Resources\AdminListCollection;

class AdminController extends Controller
{
    public function index(AdminsRequest $request, AdminRepository $adminRepository)
    {
        $adminRepository->pushCriteria(new ListRequestCriteria($request));

        return new AdminCollection($adminRepository->paginate($request->query('limit')));
    }

    public function store(CreateAdminRequest $request, AdminRepository $adminRepository)
    {
        $admin = new Admin();
        $admin->name = $request->post('name');
        $admin->email = $request->post('email');
        $admin->password = $password = Str::random(8);

        $admin = $adminRepository->createAdmin($admin);
        $admin->notify(new CreateAdminNotification($password));

        return new AdminResource($admin);
    }

    public function update(EditAdminRequest $request, $uuid, AdminRepository $adminRepository)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $admin = $adminRepository->find($uuid); // 不存在会抛异常

        $originalName = $admin->name;
        $originalEmail = $admin->email;
        $admin->name = $name;
        $admin->email = $email;

        if ($isNotify = $admin->isDirty()) {
            if ($originalName != $name) {
                $request->validate(['name' => 'unique:admins']);
            }
            if ($originalEmail != $email) {
                $request->validate(['email' => 'unique:admins']);
            }
        }

        if ($adminRepository->updateAdmin($admin) && $isNotify) {
            $admin->notify(new UpdateAdminNotification($originalName, $originalEmail));
        }

        return new AdminResource($admin);
    }

    public function destroy($uuid, AdminRepository $adminRepository)
    {
        $admin = $adminRepository->find($uuid); // 不存在会抛异常

        $adminRepository->deleteAdmin($admin);

        return $this->deleteSuccess();
    }

    public function rolesPermissions($uuid, AdminRepository $adminRepository, PermissionRepository $permissionRepository)
    {
        $admin = $adminRepository->find($uuid);

        return $this->successWithData(['roles' => $permissionRepository->getUserRoles($admin), 'permissions' => $permissionRepository->getUserPermissions($admin)]);
    }

    public function syncRolesPermissions(SyncAdminRolesPermissionsRequest $request, $uuid, AdminRepository $adminRepository, PermissionRepository $permissionRepository)
    {
        $defaultRole = $request->input('defaultRole');
        $roles = $request->input('roles');
        $permissions = $request->input('permissions');

        $admin = $adminRepository->find($uuid);

        $permissionRepository->syncUserRoles($admin, $roles, $defaultRole);
        $permissionRepository->syncUserPermissions($admin, $permissions);

        return $this->successWithMessage();
    }

    public function getAdminList(AdminRepository $adminRepository)
    {
        $adminList = $adminRepository->getAdminList();

        return new AdminListCollection($adminList);
    }
}
