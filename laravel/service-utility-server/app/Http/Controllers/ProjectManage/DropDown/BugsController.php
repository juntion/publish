<?php

namespace App\Http\Controllers\ProjectManage\DropDown;

use App\Enums\Dept\DepartmentId;
use App\Http\Controllers\Controller;
use App\ProjectManage\Repositories\DropDownUserRepository;

class BugsController extends Controller
{
    /**
     * @var DropDownUserRepository
     */
    private $userRepository;

    public function __construct(DropDownUserRepository $userRepository)
    {
        parent::__construct();

        $this->userRepository = $userRepository;
    }

    public function programPrincipal()
    {
        $users = $this->userRepository->getDeptUsers([DepartmentId::NETWORK_DESIGN, DepartmentId::SYSTEM_DEVELOPMENT]);
        return $this->successWithData(compact('users'));
    }

    public function follower()
    {
        $users = $this->userRepository->getDeptUsers([DepartmentId::NETWORK_DESIGN, DepartmentId::SYSTEM_DEVELOPMENT]);
        return $this->successWithData(compact('users'));
    }

    public function productPrincipal()
    {
        $users = $this->userRepository->getDeptUsers([DepartmentId::USER_ANALYSIS, DepartmentId::SYSTEM_ANALYSIS]);
        return $this->successWithData(compact('users'));
    }

    public function testPrincipal()
    {
        $users = $this->userRepository->getDeptUsers([DepartmentId::SYSTEM_DEVELOPMENT, DepartmentId::SYSTEM_ANALYSIS, DepartmentId::USER_ANALYSIS]);
        return $this->successWithData(compact('users'));
    }
}
