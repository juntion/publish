<?php

namespace App\Http\Controllers\Subsystem;

use App\Http\Controllers\Controller;
use App\Repositories\Subsystem\SubsystemRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubsystemsController extends Controller
{
    protected $subsystem;
    protected $user;

    public function __construct(SubsystemRepository $repository, UserRepository $user)
    {
        parent::__construct();
        $this->subsystem = $repository;
        $this->user = $user;
    }

    /**
     * 更新子系统信息
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function update(Request $request, $id)
    {
        $subsystem = $this->getInstance($this->subsystem, $id);
        $data = $request->only(['name', 'locale']);
        Validator::make($data, [
            'name' => 'required|string',
            'locale' => 'required|json',
        ])->validate();

        $subsystem->update($data);
        return $this->success();
    }

    /**
     * 子系统列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $subsystems = $this->subsystem->findAll();
        return $this->successWithData(compact('subsystems'));
    }

    /**
     * 设置首页状态
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function setHomepage(Request $request, $id)
    {
        $subsystem = $this->getInstance($this->subsystem, $id);
        $data = $request->only('status');
        $this->validateStatus($data);

        $subsystem->update(['homepage' => $data['status']]);
        return $this->success();
    }

    /**
     * 设置侧边栏状态
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function setSidebar(Request $request, $id)
    {
        $subsystem = $this->getInstance($this->subsystem, $id);
        $data = $request->only('status');
        $this->validateStatus($data);

        $subsystem->update(['sidebar' => $data['status']]);
        return $this->success();
    }

    public function validateStatus($data)
    {
        Validator::make($data, [
            'status' => 'required|numeric|in:0,1'
        ])->validate();
    }

    /**
     * 添加禁止登录的用户
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function addForbidUsers(Request $request, $id)
    {
        $subsystem = $this->getInstance($this->subsystem, $id);
        Validator::make($request->all(), [
            'user_ids' => 'required|array',
            'user_ids.*' => 'required|exists:users,id',
        ])->validate();

        try {
            $userIds = $request->input('user_ids');
            foreach ($userIds as $userId) {
                // 不存在关联记录才关联
                if (!$subsystem->forbidUsers()->wherePivot('user_id', $userId)->first()) {
                    $subsystem->forbidUsers()->attach($userId);
                }
            }
        } catch (\Exception $exception) {
            return $this->failed();
        }
        return $this->success();
    }

    /**
     * 删除禁止登录的用户
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function removeForbidUsers(Request $request, $id)
    {
        $subsystem = $this->getInstance($this->subsystem, $id);
        Validator::make($request->all(), [
            'user_ids' => 'required|array',
            'user_ids.*' => 'required|exists:users,id',
        ])->validate();
        $userIds = $request->input('user_ids');
        $users = $this->user->findWhereIn('id', $userIds);
        try {
            $subsystem->forbidUsers()->detach($users);
        } catch (\Exception $exception) {
            return $this->failed();
        }
        return $this->success();
    }

    /**
     * 查询禁止登录的用户
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function forbidUsers(Request $request, $id)
    {
        $subsystem = $this->getInstance($this->subsystem, $id);
        $users = $subsystem->forbidUsers()->get();
        return $this->successWithData(compact('users'));
    }

    /**
     * 获取所有的看守器
     * @return \Illuminate\Http\JsonResponse
     */
    public function guardNames()
    {
        $subsystems = $this->subsystem->findAll(['name', 'guard_name', 'locale']);
        return $this->successWithData($subsystems);
    }
}
