<?php

namespace App\Rpc\Service;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use App\ProjectManage\Models\Appeal;
use App\ProjectManage\Models\Demand;
use App\Rpc\Traits\RpcTrait;
use App\Support\WsGateway;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class ErpService
{
    use RpcTrait;

    /**
     * App登录
     * @param int $originId Erp系统中用户id
     * @param string $password
     * @return array
     */
    public function appLogin($originId, $password)
    {
        $user = $this->getUserModelByOriginId($originId);
        if (!$user) return self::failed('找不到该用户');
        return self::success(Hash::check($password, $user->getOriginal('password')));
    }

    /**
     * 查询用户子公司
     * @param $originId
     * @return array
     */
    public function userCompany($originId)
    {
        $user = $this->getUserModelByOriginId($originId, ['*'], true);
        $company = $user->company()->first();
        if ($user) {
            $data = [
                'user_id' => $originId,
                'company' => empty($company) ? [] : $company->toArray(),
            ];
            return self::success($data);
        }
        return self::failed('找不到该用户');
    }

    /**
     * @param $originId
     * @param string[] $columns
     * @param bool $withTrashed
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|object
     */
    protected function getUserModelByOriginId($originId, $columns = ['*'], $withTrashed = false)
    {
        $userQuery = User::query();
        if ($withTrashed) {
            $userQuery = $userQuery->withTrashed();
        }
        if (is_array($originId)) {
            return $userQuery->whereIn('origin_id', $originId)->get($columns);
        }
        return $userQuery->where('origin_id', $originId)->first($columns);
    }

    /**
     * 获取子公司列表
     * @param int $id 子公司id
     * @return array
     */
    public function companies($id = 0)
    {
        if ($id) {
            $companies = Company::query()->find($id);
            $companies = empty($companies) ? [] : $companies->toArray();
        } else {
            $companies = Company::all()->toArray();
        }
        return self::success($companies);
    }

    /**
     * 获取所有用户及其子公司信息
     * @return array
     */
    public function usersWithCompany()
    {
        $result = User::query()
            ->select(['id', 'name', 'email', 'origin_id', 'admin_level', 'company_id'])
            ->with('company')->get()->toArray();
        return self::success($result);
    }

    /**
     * @param $companyId
     * @return array user_origin_ids
     */
    public function findUserByCompanyId($companyId)
    {
        $company = Company::query()->find($companyId);
        if (!$company) {
            return self::failed('公司不存在');
        }

        $result = $company->users()->get()->pluck('origin_id')
            ->filter(function ($value) {
                return !empty($value);
            })->toArray();
        return self::success($result);
    }

    /**
     * 获取用户数据
     * @param $originId
     * @param string[] $columns
     * @param bool $withTrashed
     * @return array
     * @author: King
     * @version: 2020/5/25 11:15
     */
    public function getUserByOriginId($originId, $columns = ['*'], $withTrashed = true)
    {
        $user = $this->getUserModelByOriginId($originId, $columns, $withTrashed);
        if (!$user) {
            return self::failed('用户不存在');
        }
        return self::success($user->toArray());
    }

    /**
     * 批量获取用户数据
     * @param $originIds
     * @param string[] $columns
     * @param bool $withTrashed
     * @return array
     */
    public function getUsersByOriginIds($originIds, $columns = ['*'], $withTrashed = true)
    {
        if (!is_array($originIds)) {
            $originIds = [$originIds];
        }
        $users = $this->getUserModelByOriginId($originIds, $columns, $withTrashed);
        return self::success($users->toArray());
    }

    /**
     * 获取需求信息
     * @param $numbers
     * @param array $columns
     * @return array
     * @author: King
     * @version: 2020/5/25 11:26
     */
    public function getDemandsData($numbers, $columns = ['*'])
    {
        if (is_string($numbers)) {
            $numbers = [$numbers];
        }

        $columns = $columns[0] === '*' ? ['*'] : (in_array('number', $columns) ? $columns : array_merge(['number'], $columns));

        $result = Demand::query()->whereIn('number', $numbers)->get($columns);

        $data = collect($result)->mapWithKeys(function (Demand $item) use ($columns) {
            $attributes = $columns[0] === '*' ? $item->toArray() : $item->only($columns);
            return [$item->number => $attributes];
        })->toArray();

        return self::success($data);
    }

    /**
     * 通过 origin_id 获取 websocket Uid
     * @param $originId
     * @return array
     * @author: King
     * @version: 2020/6/11 9:56
     */
    public function getWsUidByOriginId($originId)
    {
        if (!is_array($originId)) {
            $originId = [$originId];
        }

        $users = User::query()->whereIn('origin_id', $originId)->get(['id']);
        $uid = $users->pluck('id')->toArray();

        return self::success($uid);
    }

    /**
     * 通过 websocket Uid 获取 origin_id
     * @param $uid
     * @return array
     * @author: King
     * @version: 2020/6/11 9:56
     */
    public function getOriginIdByWsUid($uid)
    {
        if (!is_array($uid)) {
            $uid = [$uid];
        }

        $users = User::query()->whereIn('id', $uid)->get(['origin_id']);
        $originId = $users->pluck('origin_id')->toArray();

        return self::success($originId);
    }

    /**
     * 调用 GatewayWorker
     * @param $name
     * @param $arguments
     * @return mixed
     * @author: King
     * @version: 2020/7/4 17:31
     */
    public function gateway($name, $arguments)
    {
        return self::success(WsGateway::{$name}(...$arguments));
    }


    /**
     * 获取部门最高职级
     * @param $dept
     * @return mixed
     * @author: King
     * @version: 2020/9/7 19:11
     */
    protected function getMaxDutyFromDept($dept)
    {
        $departments = Department::query()
            ->where('path', 'like', $dept->path . "{$dept->id}-%")
            ->get();
        $departments->push($dept);
        $deptIds = $departments->pluck('id')->toArray();
        $maxDuty = User::query()->whereHas('department', function (Builder $query) use ($deptIds) {
            $query->whereIn($query->qualifyColumn('id'), $deptIds);
        })->max('duties');

        return ['duty' => $maxDuty, 'dept_ids' => $deptIds];
    }

    /**
     * 判断人员1是否人员[2,3]的上级负责人
     * @param $leaderOriginId
     * @param $userOriginIds
     * @return array
     * @author: King
     * @version: 2020/9/7 11:23
     */
    public function leadership($leaderOriginId, $userOriginIds)
    {
        $userOriginIds = is_array($userOriginIds) ? $userOriginIds : [$userOriginIds];
        $leader = $this->getUserModelByOriginId($leaderOriginId);
        $users = User::query()->whereIn('origin_id', $userOriginIds)->get();
        $users->load('department');
        $result = [];
        foreach ($users as $user) {
            $result[$user->origin_id] = in_array($leader->department->first()->id, $user->getDeptIds()) &&
                $leader->duties > $user->duties;
        }
        return $result;
    }

    /**
     * 判断人员1是否本部门最高职级
     * @param $originId
     * @return array
     * @author: King
     * @version: 2020/9/7 19:28
     */
    public function isTopPersonInCharge($originId)
    {
        $user = $this->getUserModelByOriginId($originId);
        $duty = $this->getMaxDutyFromDept($user->basic_department);
        return self::success($duty['duty'] == $user->duties && in_array($user->basic_department->id, $duty['dept_ids']));
    }

    /**
     * 判断人员1是否人员[2,3]的上级负责人
     * @param $leaderOriginId
     * @param $userOriginIds
     * @return array
     * @author: King
     * @version: 2020/9/7 11:23
     */
    public function isLeadership($leaderOriginId, $userOriginIds)
    {
        return self::success($this->leadership($leaderOriginId, $userOriginIds));
    }

    /**
     * 判断人员1是否人员2的上级负责人
     * @param $leaderOriginId
     * @param $userOriginId
     * @return array
     * @author: King
     * @version: 2020/9/7 11:27
     */
    public function isLeader($leaderOriginId, $userOriginId)
    {
        $result = $this->leadership($leaderOriginId, $userOriginId);
        return self::success($result[$userOriginId]);
    }

    /**
     * 获取部门最高职级
     * @param $deptOriginId
     * @return mixed
     * @author: King
     * @version: 2020/9/7 12:34
     */
    public function getDeptMaxDuty($deptOriginId)
    {
        $dept = Department::query()->where('origin_id', $deptOriginId)->first();
        $duty = $this->getMaxDutyFromDept($dept);
        return self::success($duty['duty']);
    }

    /**
     * @param $originId
     * @param $withTrashed
     * @return array
     */
    public function getDeptByOriginId($originId, $withTrashed = true)
    {
        $dept = Department::query();
        if ($withTrashed) {
            $dept->withTrashed();
        }
        $dept = $dept->where('origin_id', $originId)->first();
        return self::success($dept->toArray());
    }

    /**
     * @param $originIds
     * @param $withTrashed
     * @return array
     */
    public function getDeptsByOriginIds($originIds, $withTrashed = true)
    {
        $dept = Department::query();
        if ($withTrashed) {
            $dept->withTrashed();
        }
        $depts = $dept->whereIn('origin_id', $originIds)->get()->toArray();
        return self::success($depts);
    }

    /**
     * @param $originId
     * @return array
     */
    public function getDeptTopByOriginId($originId)
    {
        $dept = Department::query()->where('origin_id', $originId)->withTrashed()->first();
        if (!$dept) {
            return self::failed('部门不存在');
        }
        $topDept = $dept->top();
        return self::success($topDept->toArray());
    }

    /**
     * 获取诉求信息
     * @param $numbers
     * @param array $columns
     * @return array
     */
    public function getAppealsData($numbers, $columns = ['*'])
    {
        if (is_string($numbers)) {
            $numbers = [$numbers];
        }

        $columns = $columns[0] === '*'
            ? ['*']
            : (in_array('number', $columns) ? $columns : array_merge(['number'], $columns));

        $result = Appeal::query()->whereIn('number', $numbers)->get($columns);

        $data = collect($result)->mapWithKeys(function (Appeal $item) use ($columns) {
            $attributes = $columns[0] === '*' ? $item->toArray() : $item->only($columns);
            return [$item->number => $attributes];
        })->toArray();

        return self::success($data);
    }
}
