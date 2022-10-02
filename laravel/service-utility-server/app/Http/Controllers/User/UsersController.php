<?php

namespace App\Http\Controllers\User;

use App\Contracts\Rpc\UserRpcInterface;
use App\Events\Mail\SendPasswordEvent;
use App\Events\User\UserCreated;
use App\Events\User\UserDelete;
use App\Events\User\UserDuties;
use App\Events\User\UserUpdate;
use App\Exports\User\UserListExport;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use App\Traits\RefreshFlagTrait;
use App\Traits\User\TempAuthCodeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller
{
    use RefreshFlagTrait, TempAuthCodeTrait;

    protected $users;

    public function __construct(UserRepository $repository)
    {
        parent::__construct();
        $this->users = $repository;
    }

    /**
     * 获取登录用户信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getLoginUser(Request $request)
    {
        $user = $this->user();
        $guardName = config('app.guard');
        // 从其他系统登录的，记录下用户登录过的系统
        if ($request->header('GuardName')) {
            $guardName = $request->header('GuardName');
            Redis::hSet('user_login_systems', $user->id . '_' . $guardName, 1);
        }
        $this->removeRefreshFlag($user->id);
        $userData = $this->users->userData($user, $guardName);

        return $this->successWithData($userData);
    }

    /**
     * 获取用户列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $users = $this->users->orderBy('id', 'desc')->getModelsList($limit)->toArray();
        return $this->successWithData($users);
    }

    /**
     * 创建用户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $data = $request->all();
        $data['password'] = Str::random(8);
        $departmentId = $request->input('department_id');
        $positionIds = $request->input('position_ids');
        $postIds = $request->input('post_ids');
        $companyId = $request->input('company_id');
        //开启事务，如果同步到ERP失败，进行回滚
        DB::beginTransaction();
        $createInfo = $this->create($data);
        if ($createInfo[0]) {
            $user = $createInfo[1];
            // 关联部门和职位
            $user->departments()->attach($departmentId, ['is_default' => 1]);
            $user->positions()->attach($positionIds);
            if ($postIds) {
                $user->posts()->attach($postIds);
            }
            $user->sidebarTemplates()->attach(2, ['guard_name' => config('app.guard')]);// 默认通用侧边栏
            // 关联子公司
            $user->company()->associate($companyId);
            $user->save();

            $userData = $user->toArray();
            $userData['positions'] = $user->positions()->get();
            $userData['posts'] = $user->posts()->get();
            $userData['departments'] = $user->departments()->get();
            try {
                // 通知ERP
                event(new UserCreated($user, $companyId, $departmentId, $positionIds[0]));
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->failedWithMessage($e->getMessage());
            }
            DB::commit();
            try {
                //发送邮件通知用户，告知密码
                event(new SendPasswordEvent($user, $data));
            } catch (\Exception $e) {
                \Log::error(__METHOD__, [$e->getMessage()]);
            }

            return $this->successWithData(['user' => $userData]);
        }
        return $this->failedWithMessage(__('error.created_failed'));
    }


    /**
     * 查询单个用户信息
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = $this->users->getUser($id);
        return $this->successWithData(compact('user'));
    }

    /**
     * 删除用户
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function delete($id)
    {
        $user = $this->getInstance($this->users, $id);
        try {
            event(new UserDelete($user));
        } catch (\Exception $e) {
            return $this->failedWithMessage($e->getMessage());
        }
        $user->delete();
        return $this->success();
    }

    /**
     * 更新用户
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function update($id, Request $request)
    {
        $user = $this->getInstance($this->users, $id);
        $data = $request->only('name', 'email', 'which_language', 'is_customer_service', 'admin_level');
        Validator::make($data, [
            'name' => [
                'required', 'max:255', 'regex:/^[a-zA-Z0-9_\-\.]+$/',
                Rule::unique('users')->whereNull('deleted_at')->ignore($user->id),
            ],
            'email' => 'required|email|max:255',
            'which_language' => 'numeric',
            'is_customer_service' => 'numeric',
            'admin_level' => 'numeric',
        ])->validate();
        $user->update($data);
        event(new UserUpdate($user, $data));
        return $this->success();
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => [
                'required', 'max:255', 'regex:/^[a-zA-Z0-9_\-\.]+$/',
                Rule::unique('users')->whereNull('deleted_at'),
            ],
            'email' => 'required|email|max:255',
            'position_ids' => 'required|array',
            'position_ids.*' => 'required|exists:positions,id',
            'post_ids' => 'array',
            'post_ids.*' => 'exists:posts,id',
            'department_id' => 'required|exists:departments,id',
            'which_language' => 'numeric',
            'is_customer_service' => 'numeric',
            'admin_level' => 'numeric',
            'company_id' => 'required|exists:companies,id',
        ]);
    }

    protected function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->users->create($data);
    }

    public function amILogin(Request $request)
    {
        $ticket = $this->users->makeTicket();
        return $this->successWithData(['ticket' => $ticket]);
    }

    // Erp中管理员等级
    public function adminLevel(UserRpcInterface $userRpc)
    {
        $res = $userRpc->adminLevel();
        if ($res['status'] == 'success') {
            return $this->successWithData($res['data']);
        }
        return $this->failed();
    }

    /**
     * 设置用户duty，并同步到erp
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function setDuty(Request $request, $id)
    {
        $user = $this->getInstance($this->users, $id);
        Validator::make($request->all(), [
            'duties' => 'required|numeric|min:0',
        ])->validate();

        $user->update($request->only('duties'));
        $duties = $request->input('duties');
        $this->users->setErpPermissionsOnSetDuties($user, $duties);

        event(new UserDuties($user, $duties));
        return $this->success();
    }

    /**
     * 登录历史记录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginHistory(Request $request)
    {
        $limit = $request->input('limit', 10);
        $result = $this->user()->loginHistory()->limit($limit)->get();
        return $this->successWithData($result);
    }

    /**
     * 重置用户密码
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function resetPassword(Request $request, $id)
    {
        Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed'
        ])->validate();

        $user = $this->getInstance($this->users, $id);

        if ($msg = $this->users->validatePassword($user, $request->input('password'))) {
            return $this->failedWithMessage($msg);
        }

        $user->update([
            'password' => Hash::make($request->input('password')),
            'update_pass_time' => now(),
        ]);
        return $this->success();
    }

    /**
     * 用户搜索列表(模糊匹配)
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchList(Request $request)
    {
        $request->validate(['name' => 'required|string']);
        $users = $this->users->searchList($request->name);
        return $this->successWithData(compact('users'));
    }

    /**
     * 导出用户列表
     * @param UserListExport $export
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function userListExport(UserListExport $export)
    {
        return Excel::download($export, $export->exportFileName());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function tempAuthCode()
    {
        [$code, $ttl] = $this->setTempAuthCode(Auth::id());
        return $this->successWithData([
            'code' => $code,
            'expires_at' => $ttl,
        ]);
    }
}
