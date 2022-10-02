<?php

namespace App\Http\Controllers\User;

use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CompaniesController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        parent::__construct();

        $this->user = $user;
    }

    /**
     * 设置用户子公司
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function setUserCompany(Request $request, $id)
    {
        $user = $this->getInstance($this->user, $id);
        Validator::make($request->all(), [
            'company_id' => 'required|numeric|exists:companies,id',
        ])->validate();

        $user->company()->associate($request->input('company_id'));
        $user->save();
        return $this->success();
    }

    /**
     * 批量设置用户子公司
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchSetUserCompany(Request $request)
    {
        Validator::make($request->all(), [
            'company_id' => 'required|numeric|exists:companies,id',
            'user_ids' => 'required|array',
            'user_ids.*' => 'required|exists:users,id',
        ])->validate();

        $users = $this->user->findWhereIn('id', $request->input('user_ids'));
        foreach ($users as $user) {
            $user->company()->associate($request->input('company_id'));
            $user->save();
        }
        return $this->success();
    }
}
