<?php

namespace App\Http\Controllers\User;

use App\Repositories\Subsystem\SubsystemRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SubsystemsController extends Controller
{
    protected $user;
    protected $subsystem;

    public function __construct(UserRepository $user, SubsystemRepository $subsystem)
    {
        parent::__construct();
        $this->user = $user;
        $this->subsystem = $subsystem;
    }


    /**
     * 添加用户禁止登录的系统
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function addUserForbid(Request $request, $id)
    {
        Validator::make($request->all(), [
            'subsystem_id' => 'required|numeric',
        ])->validate();

        $user = $this->getInstance($this->user, $id);
        $subsystemId = $request->input('subsystem_id');
        if (!$user->forbidSubsystems()->wherePivot('subsystem_id', $subsystemId)->first()) {
            $user->forbidSubsystems()->attach($subsystemId);
        }
        return $this->success();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function removeUserForbid(Request $request, $id)
    {
        Validator::make($request->all(), [
            'subsystem_id' => 'required|numeric',
        ])->validate();

        $user = $this->getInstance($this->user, $id);
        $user->forbidSubsystems()->detach($request->input('subsystem_id'));
        return $this->success();
    }

    /**
     * 查询用户禁止登录的系统
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function getForbidUser(Request $request, $id)
    {
        $user = $this->getInstance($this->user, $id);
        $forbidSubsystems = $user->forbidSubsystems()->get();
        return $this->successWithData(['subsystems' => $forbidSubsystems->pluck('id')]);
    }

    /**
     * 允许登录的用户
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function allowUsers(Request $request, $id)
    {
        $limit = $request->input('limit');
        $subsystem = $this->getInstance($this->subsystem, $id);
        $allowUsers = $this->user->allowUsers($subsystem, $limit);
        return $this->successWithData($allowUsers);
    }
}
