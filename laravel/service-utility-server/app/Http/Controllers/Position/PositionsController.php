<?php

namespace App\Http\Controllers\Position;

use App\Repositories\Position\PositionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PositionsController extends Controller
{
    protected $position;

    public function __construct(PositionRepository $position)
    {
        parent::__construct();
        $this->position = $position;
    }

    /**
     * 创建职位
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->only(['name', 'comment', 'locale']);
        $this->validator($data);

        $createInfo = $this->position->create($data);
        if ($createInfo[0]) {
            return $this->successWithData(['position' => $createInfo[1]]);
        }
        return $this->failedWithMessage(__('error.created_failed'));
    }

    /**
     * 更新职位
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function update(Request $request, $id)
    {
        $position = $this->getInstance($this->position, $id);
        $data = $request->only(['name', 'comment', 'locale']);
        $this->validator($data);

        $position->update($data);
        return $this->success();
    }

    /**
     * 删除职称
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function delete($id)
    {
        $position = $this->getInstance($this->position, $id);
        // 系统职称不允许删除
        if ($position->is_system) {
            return $this->failedWithMessage(__('error.system_position_not_allow_delete'));
        }
        $position->delete();
        return $this->success();
    }

    /**
     * 获取某职称下的用户
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function users($id)
    {
        $position = $this->getInstance($this->position, $id);
        $users = $position->users()->get();
        return $this->successWithData(compact('users'));
    }

    /**
     * 所有职称
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        $isSystem = $request->input('is_system', false);
        if ($isSystem) {
            $positions = $this->position->findWhere(['is_system' => 1], ['*'], ['posts']);
        } else {
            $positions = $this->position->findAll(['*'], ['posts']);
        }
        return $this->successWithData(compact('positions'));
    }

    /**
     * 职称列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $limit = $request->input('limit');
        $data = $this->position->orderBy('id', 'desc')->getModelsList($limit);
        return $this->successWithData($data);
    }

    public function validator($data)
    {
        Validator::make($data, [
            'name' => 'required|string',
            'comment' => 'required|string',
            'locale' => 'required|json',
        ])->validate();
    }
}
