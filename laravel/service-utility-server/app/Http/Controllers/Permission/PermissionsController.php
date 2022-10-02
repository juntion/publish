<?php

namespace App\Http\Controllers\Permission;

use App\Repositories\Permission\PermissionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PermissionsController extends Controller
{
    protected $permission;

    public function __construct(PermissionRepository $permission)
    {
        parent::__construct();
        $this->permission = $permission;
    }

    /**
     * 权限列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $permissions = $this->permission->getModelsList($limit);
        return $this->successWithData($permissions);
    }

    /**
     * 更新权限
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->only(['comment', 'locale']);
        Validator::make($data, [
            'comment' => 'required|string',
            'locale' => 'required|json',
        ])->validate();

        $updateInfo = $this->permission->update($id, $data);
        if ($updateInfo[0]) {
            return $this->success();
        }
        return $this->failedWithMessage(__('error.update.failed'));
    }

    /**
     * 权限组数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function group(Request $request)
    {
        Validator::make($request->all(), [
            'guard_name' => 'required|string',
        ])->validate();
        $guardName = $request->input('guard_name');
        $permissions = $this->permission->findWhere(['guard_name' => $guardName])
            ->groupBy('group')
            ->map(function ($item, $group) {
                return ['name' => __($group), 'data' => $item];
            })->values();

        return $this->successWithData(compact('permissions'));
    }
}
