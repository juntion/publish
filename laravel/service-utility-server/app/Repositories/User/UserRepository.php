<?php

namespace App\Repositories\User;

use App\Enums\ProjectManage\TeamType;
use App\Enums\User\Duty;
use App\Models\AccessToken;
use App\Models\Department;
use App\Models\Subsystem;
use App\Models\User;
use App\ProjectManage\Models\BugHandler;
use App\ProjectManage\Models\BugPrincipal;
use App\ProjectManage\Models\Project;
use App\ProjectManage\Models\ReleaseProductAdmin;
use App\ProjectManage\Models\Team;
use App\Repositories\BaseRepository;
use App\Repositories\Sidebar\SidebarsTemplateRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class UserRepository extends BaseRepository
{
    protected $model;
    protected $sidebarTemplate;

    protected $allowedSearches = ['id', 'name', 'email', 'positions.id', 'departments.id', 'company_id', 'roles.id', 'sidebarTemplates.id'];
    protected $allowedScopeSearches = ['updated_date'];

    protected $allowedIncludes = ['departments', 'department', 'positions', 'posts', 'company'];

    protected $allowedAppends = ['department_ids'];

    public function __construct(User $user, SidebarsTemplateRepository $sidebarTemplate)
    {
        $this->model = $user;
        $this->sidebarTemplate = $sidebarTemplate;
    }

    public function allowUsers(Subsystem $subsystem, $limit)
    {
        $limit = $limit ?: 20;
        $forbidUsers = $subsystem->forbidUsers()->get();
        return $this->queryBuilder()->whereNotIn('id', $forbidUsers->pluck('id'))->paginate($limit);
    }

    public function getUser($id)
    {
        return $this->model->with(['positions', 'department', 'posts', 'company'])->find($id)->append(['department_ids', 'avatar']);
    }

    /**
     * @param User $user
     * @param $guardName
     * @return array
     * @throws \Exception
     */
    public function userData(User $user, $guardName)
    {
        $userData = collect($user->append(['basic_department', 'avatar']))->toArray();

        // 部门信息
        $userData['department'] = $user->department()->get()->toArray();  // 默认部门
        $userData['department_ids'] = $user->department_ids->toArray();  // 其他部门 ids
        $userData['forbid_pages'] = $user->forbidPages()->get()->toArray();
        // 子公司
        $userData['company'] = $user->company()->get()->toArray();
        // 职位
        $userData['positions'] = $user->positions()->get()->toArray();
        // 侧边栏
        $userTemplates = $user->sidebarTemplates()->wherePivot('guard_name', $guardName)->get();
        $categories = $userTemplates->flatmap(function ($template) {
            return $template->categories()->where('parent_id', 0)->with('pages')->get();
        });
        $sidebars = $this->sidebarTemplate->getTree($categories)['tree'];
        // 主页
        $homepage = $user->pages()->wherePivot('guard_name', $guardName)->get()->toArray();
        // 权限
        $permissions = $user->getAllPermissions();
        $permissions = $permissions->filter(function ($permission) use ($guardName) {
            return $permission->guard_name == $guardName;
        })->flatten(1)->toArray();

        return [
            'user' => $userData,
            'sidebars' => $sidebars,
            'dashboard' => $homepage,
            'permissions' => $permissions,
            'pm_user_type' => $this->pmUserType($user),
        ];
    }

    /**
     * @param User $user
     * @param $duties
     */
    public function setErpPermissionsOnSetDuties(User $user, $duties)
    {
        // 设置职责和设置erp权限的权限
        $permissions = [
            'users.setDuty',
        ];
        // 设置为主管以上，增加相关权限
        if ($duties >= Duty::SUPERVISOR) {
            $user->givePermissionTo($permissions);
        } else {
            $user->revokePermissionTo($permissions);
        }
    }

    /**
     * @param User $user
     * @param $guardName
     * @return array
     * @throws \Exception
     */
    public function getRolesAndPermissions(User $user, $guardName)
    {
        // 用户角色
        $roles = $user->roles;
        $roles = $roles->filter(function ($role) use ($guardName) {
            return $role->guard_name == $guardName;
        })->flatten(1);
        // 用户权限
        $permissions = $user->getAllPermissions();
        $permissions = $permissions->filter(function ($permission) use ($guardName) {
            return $permission->guard_name == $guardName;
        })->flatten(1);
        return compact('roles', 'permissions');
    }

    /**
     * @param User $user
     * @param string $token
     * @param int $expiration 时间戳
     */
    public function saveToken(User $user, $token, $expiration)
    {
        // 存储token，为日后同步注销做准备
        AccessToken::create([
            'user_id' => $user->id,
            'access_token' => $token,
            'expires_at' => Carbon::createFromTimestamp($expiration)->toDateTimeString(),
        ]);
    }

    /**
     * @param $name
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function searchList($name)
    {
        $users = User::query()->where('name', 'like', "%$name%")->with('department')->get();
        return $users->map(function ($user) {
            $dept = optional($user->department->first());
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'dept_id' => $dept->id,
                'dept_name' => $dept->name,
            ];
        });
    }

    /**
     * 项目管理用户类型
     * @param User $user
     * @return array
     */
    public function pmUserType(User $user)
    {
        $position = $user->positions()->first(['number']);
        $post = $user->posts()->first(['number']);
        $positions = $position ? $position->number : '';
        $posts = $post ? $post->number : '';

        $result = [];

        // 产品负责人: 在产品维护中绑定了产品负责人数据
        $result['product_owner'] = Team::query()->where('type', TeamType::TYPE_PRODUCT)->where('user_id', $user->id)->where('is_default', 1)->exists();

        // 产品跟进人：属于用户分析部、系统分析部
        $secondary_product_owner = false;
        if ($result['product_owner'] == false){
            $secondary_product_owner = Team::query()->where('type', TeamType::TYPE_PRODUCT)->where('user_id', $user->id)->where('is_default', 0)->exists();
        }
        $result['product_followers'] = in_array($positions, ['J0012', 'J0013']) || $secondary_product_owner;

        // IT对接人：拥有发布诉求权限
        $result['it_matchmaker'] = $user->hasPermissionTo('pm.appeals.store');

        // 任务负责人：在产品维护中绑定了设计、开发、或测试负责人
        $result['task_leader'] = Team::query()
            ->whereIn('type', [TeamType::TYPE_DESIGN, TeamType::TYPE_DEVELOP, TeamType::TYPE_TEST])
            ->where('user_id', $user->id)->exists();

        // 任务跟进人：属于系统开发部、网络设计部
        $result['task_follower'] = in_array($positions, ['J0014', 'J0015']);

        // 产品分析员：属于用户分析部，系统分析部 系统开发部 网络设计部
        $result['product_analyst'] = in_array($positions, ['J0012', 'J0013', 'J0014', 'J0015']);

        // 项目经理：项目数据中有当前用户作为项目经理的
        $result['project_manager'] = Project::query()->where('principal_user_id', $user->id)->exists();

        $result['link_type'] = '';
        if ($positions == 'J0014') {
            $result['link_type'] = $posts == 'G0006' ? 'test' : 'dev';
        } elseif ($positions == 'J0015')  {
            $result['link_type'] = 'design';
        }

        // 内控
        $result['internal_control'] = $user->hasPermissionTo('pm.bugs.internalControlExamine');
        // 财务
        $result['finance'] = $user->hasPermissionTo('pm.bugs.financeExamine');
        // 程序负责人
        $result['bug_program_principal'] = BugPrincipal::query()->where('frontend_program_user_id', $user->id)
            ->orWhere('backend_program_user_id', $user->id)->exists();
        // 程序跟进人
        $result['bug_program_follower'] = BugHandler::query()->where('handler_id', $user->id)->exists();
        // 测试负责人
        $result['bug_test_principal'] = BugPrincipal::query()->where('test_user_id', $user->id)->exists();
        // 产品负责人
        $result['bug_product_principal'] = BugPrincipal::query()->where('backend_product_user_id', $user->id)
            ->orWhere('frontend_product_user_id', $user->id)->exists();

        // 版本管理员
        $result['version_admin'] = ReleaseProductAdmin::query()->where('user_id', $user->id)->exists();

        return $result;
    }

    /**
     * 验证密码可用性
     * @param $user
     * @param $password
     * @return array|string|\Underscore\Underscore|null
     */
    public function validatePassword($user, $password)
    {
        $msg = '';
        // 密码复杂度： 至少包含数字、大小写
        $passwordRule = '/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[A-Za-z0-9$@$!%*#?&]{8,16}$/';
        if (!preg_match($passwordRule, $password)) {
            return __('passwords.rule');
        }

        // 强制密码历史：至少3次
        if ($pwdHistory = $user->password_history) {
            collect($pwdHistory)->take(3)->each(function ($pass) use ($password, &$msg) {
                if (Hash::check($password, $pass)) {
                    $msg = __('passwords.recentUse');
                }
            });
        }
        return $msg;
    }

    /**
     * 生成 Token 票据
     * @return string
     * @author: King
     * @version: 2020/6/24 17:09
     */
    public function makeTicket()
    {
        $str = Str::random(12) . now()->getTimestamp() . Auth::id();
        $arr = str_split($str);
        shuffle($arr);
        $ticket = implode('', $arr);
        Cache::tags('user_tickets')->put($ticket, Auth::getToken()->get(), 60 * 5);
        return $ticket;
    }

    /**
     * 获取某部门下所有用户的列表
     * @param $deptId
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @author: King
     * @version: 2020/7/21 15:31
     */
    public function getUserListByDept($deptId, $limit = 20)
    {
        $dept = Department::query()->find($deptId);
        $result = $this->whereHas('department', function (Builder $query) use ($dept) {
            $query->where('path', 'like', $dept->path . $dept->id . '-%')
                ->orWhere('id', $dept->id);
        })->getModelsList($limit);
        return $result;
    }

    /**
     * 导出列表
     */
    public function exportData()
    {
        if (!request()->has('sort')) {
            $this->orderBy('name', 'asc');
        }
        $result = $this->getModels();
        $result->load(['department', 'positions', 'posts', 'company']);
        return $result;
    }
}
