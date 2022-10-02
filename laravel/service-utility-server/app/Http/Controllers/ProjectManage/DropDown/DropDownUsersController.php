<?php

namespace App\Http\Controllers\ProjectManage\DropDown;

use App\Http\Controllers\Controller;
use App\ProjectManage\Repositories\DropDownTaskRepository;
use App\ProjectManage\Repositories\DropDownUserRepository;
use Illuminate\Http\Request;

class DropDownUsersController extends Controller
{

    /**
     * @var DropDownUserRepository
     */
    private $dropDownUser;

    /**
     * @var DropDownTaskRepository
     */
    private $dropDownTask;

    public function __construct(DropDownUserRepository $dropDownUser, DropDownTaskRepository $dropDownTask)
    {
        parent::__construct();

        $this->dropDownUser = $dropDownUser;
        $this->dropDownTask = $dropDownTask;
    }

    /**
     * 项目发布人（经理/负责人）
     */
    public function projectPrincipal()
    {
        $users = $this->dropDownTask->getUsersByPosition(['J0012', 'J0013', 'J0014', 'J0015']);
        return $this->successWithData(compact('users'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function demandPublisher()
    {
        $users = $this->dropDownUser->getUsersByPermissions('pm.demand.create');
        return $this->successWithData(compact('users'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function testTaskPublisher()
    {
        $users = $this->dropDownUser->getUsersByPermissions(['pm.tasks.test.store', 'pm.demand.create']); // 加上需求发布人
        return $this->successWithData(compact('users'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function devTaskPublisher()
    {
        $users = $this->dropDownUser->getUsersByPermissions(['pm.tasks.dev.store', 'pm.demand.create']); // 加上需求发布人
        return $this->successWithData(compact('users'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function designTaskPublisher()
    {
        $users = $this->dropDownUser->getUsersByPermissions(['pm.tasks.design.store', 'pm.demand.create']); // 加上需求发布人
        return $this->successWithData(compact('users'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function frontendTaskPublisher()
    {
        $users = $this->dropDownUser->getUsersByPermissions(['pm.tasks.frontend.store', 'pm.demand.create']); // 加上需求发布人
        return $this->successWithData(compact('users'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobileTaskPublisher()
    {
        $users = $this->dropDownUser->getUsersByPermissions(['pm.tasks.mobile.store', 'pm.demand.create']); // 加上需求发布人
        return $this->successWithData(compact('users'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function appealPublisher()
    {
        $users = $this->dropDownUser->getUsersByPermissions('pm.appeals.store');
        return $this->successWithData(compact('users'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function department()
    {
        $departments = $this->dropDownUser->getDepartments();
        return $this->successWithData(compact('departments'));
    }

    public function getDepartmentUser(Request $request)
    {
        $users = $this->dropDownUser->getDepartmentUser($request);
        return $this->successWithData(compact('users'));
    }
}
