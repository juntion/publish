<?php

namespace App\Http\Controllers\ProjectManage\Appeal;

use App\Exceptions\System\InvalidParameterException;
use App\Exceptions\System\InvalidStatusException;
use App\Exports\AppealsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectManage\Appeal\AppealStoreRequest;
use App\Http\Requests\ProjectManage\Appeal\CreateDemandRequest;
use App\Http\Requests\ProjectManage\Appeal\DisassembleRequest;
use App\Http\Requests\ProjectManage\Appeal\FollowRequest;
use App\Http\Requests\ProjectManage\Appeal\LabelRequest;
use App\Http\Requests\ProjectManage\Appeal\ProductRequest;
use App\Http\Requests\ProjectManage\Appeal\RevocationRequest;
use App\Http\Requests\ProjectManage\Appeal\VerifyRequest;
use App\ProjectManage\Models\Appeal;
use App\ProjectManage\Models\Label;
use App\ProjectManage\Repositories\AppealListRepository;
use App\ProjectManage\Repositories\AppealRepository;
use App\ProjectManage\Repositories\DemandRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class AppealsController extends Controller
{
    /**
     * @var AppealRepository
     */
    private $appeal;
    private $demand;

    public function __construct(AppealRepository $appeal, DemandRepository $demand)
    {
        parent::__construct();

        $this->appeal = $appeal;
        $this->demand = $demand;
    }

    /**
     * 发布诉求
     * @param AppealStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AppealStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->appeal->store($request);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            if ($e instanceof InvalidParameterException) {
                return $this->failedWithMessage($e->getMessage());
            }
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();

        return $this->success();
    }

    /**
     * 编辑诉求
     * @param AppealStoreRequest $request
     * @param Appeal $appeal
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AppealStoreRequest $request, Appeal $appeal)
    {
        DB::beginTransaction();
        try {
            $this->appeal->update($appeal, $request);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            if ($e instanceof InvalidParameterException) {
                return $this->failedWithMessage($e->getMessage());
            }
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();

        return $this->success();
    }

    /**
     * 删除诉求
     * @param Appeal $appeal
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(Appeal $appeal)
    {
        if (!$this->user()->can('delete', $appeal)) {
            throw new InvalidStatusException();
        }
        DB::beginTransaction();
        try {
            $this->appeal->delete($appeal);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 撤销诉求
     * @param Request $request
     * @param Appeal $appeal
     * @return \Illuminate\Http\JsonResponse
     */
    public function revocation(RevocationRequest $request, Appeal $appeal)
    {
        $this->appeal->revocation($appeal);

        return $this->success();
    }

    /**
     * 查看诉求状态变更日志
     * @param Appeal $appeal
     * @return \Illuminate\Http\JsonResponse
     */
    public function logs(Appeal $appeal)
    {
        return $this->successWithData(['status_logs' => $appeal->logs()]);
    }

    /**
     * 给诉求贴标签
     * @param Request $request
     * @param Appeal $appeal
     * @return \Illuminate\Http\JsonResponse
     */
    public function labels(LabelRequest $request, Appeal $appeal)
    {
        $this->appeal->labels($appeal, $request->label_ids ?? []);

        return $this->success();
    }

    /**
     * 删除诉求标签
     * @param Request $request
     * @param Appeal $appeal
     * @param Label $label
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function deleteLabel(Request $request, Appeal $appeal, Label $label)
    {
        if ($this->user()->cant('deleteLabel', $appeal)) {
            throw new InvalidStatusException();
        }
        $this->appeal->deleteLabel($appeal, $label);

        return $this->success();
    }

    /**
     * 认领诉求
     * @param Appeal $appeal
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidStatusException
     */
    public function apply(Appeal $appeal)
    {
        if (!$this->user()->can('apply', $appeal)) {
            throw new InvalidStatusException();
        }
        $this->appeal->apply($appeal);

        return $this->success();
    }

    /**
     * 取消认领诉求
     * @param Appeal $appeal
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function applyCancel(Appeal $appeal)
    {
        if (!$this->user()->can('applyCancel', $appeal)) {
            throw new InvalidStatusException();
        }
        $this->appeal->applyCancel($appeal);

        return $this->success();
    }

    /**
     * 指定或变更跟进人
     * @param FollowRequest $request
     * @param Appeal $appeal
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow(FollowRequest $request, Appeal $appeal)
    {
        $this->appeal->follow($appeal, $request);
        return $this->success();
    }

    /**
     * 诉求更改产品分类
     * @param ProductRequest $request
     * @param Appeal $appeal
     * @return \Illuminate\Http\JsonResponse
     */
    public function products(ProductRequest $request, Appeal $appeal)
    {
        DB::beginTransaction();
        try {
            $this->appeal->products($appeal, $request);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            if ($e instanceof InvalidParameterException) {
                return $this->failedWithMessage($e->getMessage());
            }
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 审核诉求
     * @param VerifyRequest $request
     * @param Appeal $appeal
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(VerifyRequest $request, Appeal $appeal)
    {
        DB::beginTransaction();
        try {
            $this->appeal->verify($appeal, $request);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 拆解诉求
     * @param DisassembleRequest $request
     * @param Appeal $appeal
     * @return \Illuminate\Http\JsonResponse
     */
    public function disassemble(DisassembleRequest $request, Appeal $appeal)
    {
        DB::beginTransaction();
        try {
            $this->appeal->disassemble($appeal, $request);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            if ($e instanceof InvalidParameterException) {
                return $this->failedWithMessage($e->getMessage());
            }
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 查看诉求详情
     * @param Appeal $appeal
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(Appeal $appeal)
    {
        $appeals = $this->appeal->details($appeal);
        return $this->successWithData(compact('appeals'));
    }

    /**
     * 诉求列表
     * @param Request $request
     * @param AppealListRepository $appealList
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request, AppealListRepository $appealList)
    {
        $result = $appealList->getList($request->input('limit'));

        return $this->successWithData($result);
    }

    /**
     * 诉求（合并）立项
     * @param CreateDemandRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Demand\InvaildParameterException
     */
    public function createDemand(CreateDemandRequest $request)
    {
        $appealIds = $request->input('appeal_ids');
        $appeals = Appeal::query()->whereIn('id', $appealIds)->get();
        if ($appeals->pluck('principal_user_id')->unique()->count() > 1) {
            return $this->failedWithMessage('产品负责人不相同，不可合并立项');
        }
        $appeals->each(function (Appeal $appeal) {
            if ($this->user()->cant('createDemand', $appeal)) {
                throw new InvalidStatusException();
            }
        });
        $this->demand->createDemands($request);
        return $this->success();
    }

    /**
     * 取消立项
     * @param Appeal $appeal
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function cancelDemand(Appeal $appeal)
    {
        if ($this->user()->cant('cancelDemand', $appeal)) {
            throw new InvalidStatusException();
        }
        DB::beginTransaction();
        try {
            $this->appeal->cancelDemand($appeal);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 添加或取消关注
     * @param Appeal $appeal
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidParameterException
     */
    public function attention(Appeal $appeal)
    {
        $this->appeal->attention($appeal, $this->user());
        return $this->success();
    }

    /**
     * 获取诉求产品负责人下拉选项
     * @param Appeal $appeal
     * @return \Illuminate\Http\JsonResponse
     */
    public function principal(Appeal $appeal)
    {
        $users = $this->appeal->principal($appeal);
        return $this->successWithData(compact('users'));
    }

    /**
     * 诉求更改产品负责人
     * @param Appeal $appeal
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setPrincipal(Appeal $appeal, Request $request)
    {
        if (!$this->user()->can('setPrincipal', $appeal)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);
        $this->appeal->setPrincipal($appeal, $data);
        return $this->success();
    }

    /**
     * 诉求导出
     * @param AppealsExport $export
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel(AppealsExport $export)
    {
        return Excel::download($export, $export->exportFileName());
    }

    /**
     * 诉求转移
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function transfer(Request $request)
    {
        $data = $request->validate([
            'appeal_ids' => 'required|array',
            'appeal_ids.*' => 'required|integer|exists:pm_appeals,id',
            'receiver_id' => 'required|integer|exists:users,id',
        ], [], [
            'appeal_ids' => '诉求ID集合',
            'appeal_ids.*' => '诉求ID',
            'receiver_id' => '接收用户ID',
        ]);
        DB::beginTransaction();
        try {
            $this->appeal->transfer($data);
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e instanceof InvalidParameterException) {
                return $this->failedWithMessage($e->getMessage());
            }
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }
}
