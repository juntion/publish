<?php

namespace App\Http\Controllers\ProjectManage\DropDown;

use App\Enums\ProjectManage\TeamMemberType;
use App\Enums\ProjectManage\TeamType;
use App\Http\Controllers\Controller;
use App\ProjectManage\Repositories\DropDownTaskRepository;

class DropDownTasksController extends Controller
{
    private $dropDownTask;

    public function __construct(DropDownTaskRepository $repository)
    {
        parent::__construct();

        $this->dropDownTask = $repository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function productPrincipal()
    {
        $users = $this->dropDownTask->getTeamsByType();
        return $this->successWithData(compact('users'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function designPrincipal()
    {
        $users = $this->dropDownTask->designPrincipal();
        return $this->successWithData(compact('users'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function devPrincipal()
    {
        $users = $this->dropDownTask->devPrincipal();
        return $this->successWithData(compact('users'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function testPrincipal()
    {
        $users = $this->dropDownTask->testPrincipal();
        return $this->successWithData(compact('users'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function productMember()
    {
        $users = $this->dropDownTask->getTeamMembersByType();
        return $this->successWithData(compact('users'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function productFollower()
    {
        $users = $this->dropDownTask->getUsersByPosition(['J0012', 'J0013', 'J0014', 'J0015']);
        return $this->successWithData(compact('users'));
    }

    /**
     * 交互负责人
     * @return \Illuminate\Http\JsonResponse
     */
    public function interactionPrincipal()
    {
        $users = $this->dropDownTask->getTeamMembersByType(TeamMemberType::TYPE_INTERACTIVE);
        return $this->successWithData(compact('users'));
    }

    /**
     * 视觉负责人
     * @return \Illuminate\Http\JsonResponse
     */
    public function visionPrincipal()
    {
        $users = $this->dropDownTask->getTeamMembersByType(TeamMemberType::TYPE_VISUAL);
        return $this->successWithData(compact('users'));
    }

    /**
     * 前端负责人
     * @return \Illuminate\Http\JsonResponse
     */
    public function frontEndPrincipal()
    {
        $users = $this->dropDownTask->getTeamsByType(TeamType::TYPE_FRONTEND);
        return $this->successWithData(compact('users'));
    }

    /**
     * 移动端负责人
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobilePrincipal()
    {
        $users = $this->dropDownTask->getTeamsByType(TeamType::TYPE_MOBILE);
        return $this->successWithData(compact('users'));
    }

    /**
     * 美工负责人
     * @return \Illuminate\Http\JsonResponse
     */
    public function artistPrincipal()
    {
        $users = $this->dropDownTask->getTeamMembersByType(TeamMemberType::TYPE_ART);
        return $this->successWithData(compact('users'));
    }

    /**
     * 设计任务处理人
     * @return \Illuminate\Http\JsonResponse
     */
    public function designTaskHandler()
    {
        $users = $this->dropDownTask->getUsersByPosition('J0015');
        return $this->successWithData(compact('users'));
    }

    /**
     * 所有分析、开发和设计人员
     * @return \Illuminate\Http\JsonResponse
     */
    public function systemDevUser()
    {
        $users = $this->dropDownTask->getUsersByPosition(['J0012', 'J0013', 'J0014', 'J0015']);
        return $this->successWithData(compact('users'));
    }

    /**
     * 测试任务处理人
     * @return \Illuminate\Http\JsonResponse
     */
    public function testTaskHandler()
    {
        $users = $this->dropDownTask->testTaskHandler();
        return $this->successWithData(compact('users'));
    }

    /**
     * 开发任务处理人
     * @return \Illuminate\Http\JsonResponse
     */
    public function devTaskHandler()
    {
        $users = $this->dropDownTask->devTaskHandler();
        return $this->successWithData(compact('users'));
    }

    /**
     * 前端任务处理人
     * @return \Illuminate\Http\JsonResponse
     */
    public function frontendTaskHandler()
    {
        $users = $this->dropDownTask->getUsersByPosition(['J0014', 'J0015']);
        return $this->successWithData(compact('users'));
    }

    /**
     * 移动端处理人
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobileTaskHandler()
    {
        $users = $this->dropDownTask->getUsersByPosition(['J0014', 'J0015']);
        return $this->successWithData(compact('users'));
    }
}
