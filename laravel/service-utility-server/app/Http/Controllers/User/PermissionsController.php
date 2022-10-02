<?php

namespace App\Http\Controllers\User;

use App\Enums\Permission\PermissionLogType;
use App\Events\Auth\PermissionUpdate;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Traits\RefreshFlagTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PermissionsController extends Controller
{
    use RefreshFlagTrait;

    protected $user;

    public function __construct(UserRepository $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * 查询用户权限
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function permissions(Request $request, $id)
    {
        Validator::make($request->all(), [
            'guard_name' => 'required|string',
        ])->validate();
        $guardName = $request->input('guard_name');

        $user = $this->getInstance($this->user, $id);
        // 获取用户所有权限
        $permissions = $user->getAllPermissions();
        $permissions = $permissions->filter(function ($permission) use ($guardName) {
            return $permission->guard_name == $guardName;
        })->flatten(1);
        return $this->successWithData(compact('permissions'));
    }

    /**
     * 更新用户权限
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function syncPermissions(Request $request, $id)
    {
        Validator::make($request->all(), [
            'permission_ids' => 'required|array',
            'permission_ids.*' => 'required|exists:permissions,id',
            'guard_name' => 'required|string',
        ])->validate();

        $guardName = $request->input('guard_name');
        $user = $this->getInstance($this->user, $id);
        $user->guard_name = $guardName;
        DB::beginTransaction();
        try {
            $old = $user->permissions()->where('guard_name', $guardName)->pluck('id')->toArray();
            if ($old) {
                $user->permissions()->detach($old);
            }
            $newPermissionIds = $request->input('permission_ids');
            $user->givePermissionTo($newPermissionIds);

            if (array_diff($old, $newPermissionIds) || array_diff($newPermissionIds, $old)) {
                event(new PermissionUpdate($user->id, PermissionLogType::USER_PERMISSION));
                $user->createPermissionLog($old, $newPermissionIds, PermissionLogType::USER_PERMISSION);
            }

            DB::commit();
            $this->addRefreshFlag($user->id, $this->FLAG_PERMISSION);
            return $this->success();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * 查询用户的角色、权限日志
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function permissionLogs(User $user)
    {
        $result = $user->getPermissionLogs();
        return $this->successWithData($result);
    }
}
