<?php

namespace App\Http\Controllers\ProjectManage\Bug;

use App\Exceptions\System\InvalidParameterException;
use App\Exports\BugExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectManage\Bug\BugReexamineRequest;
use App\Http\Requests\ProjectManage\Bug\BugsStoreRequest;
use App\Http\Requests\ProjectManage\Bug\BugSubmitResultRequest;
use App\ProjectManage\Models\Bug;
use App\ProjectManage\Models\BugAccept;
use App\ProjectManage\Repositories\BugsListRepository;
use App\ProjectManage\Repositories\BugsRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BugsController extends Controller
{
    /**
     * @var BugsRepository
     */
    private $bugsRepository;

    public function __construct(BugsRepository $bugsRepository)
    {
        parent::__construct();
        $this->bugsRepository = $bugsRepository;
    }

    /**
     * @param BugsStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BugsStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->bugsRepository->store($request->validated());
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
     * @param BugsStoreRequest $request
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BugsStoreRequest $request, Bug $bug)
    {
        $this->checkPolicy($bug, 'update');
        DB::beginTransaction();
        try {
            $this->bugsRepository->update($bug, $request->validated());
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
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Bug $bug)
    {
        $bug = $this->bugsRepository->detail($bug);
        return $this->successWithData(compact('bug'));
    }

    /**
     * 撤销 bug
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     */
    public function revocation(Bug $bug)
    {
        $this->checkPolicy($bug, 'revocation');
        $this->bugsRepository->revocation($bug);
        return $this->success();
    }

    /**
     * 状态日志
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     */
    public function logs(Bug $bug)
    {
        return $this->successWithData(['status_logs' => $bug->logs()]);
    }

    /**
     * 审批日志
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     */
    public function examineLogs(Bug $bug)
    {
        return $this->successWithData(['examine_logs' => $bug->examineStatusLogs()]);
    }

    /**
     * @param Request $request
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     */
    public function testPrincipal(Request $request, Bug $bug)
    {
        $this->checkPolicy($bug, 'testPrincipal');
        $data = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);
        $this->bugsRepository->testPrincipal($bug, $data['user_id']);
        return $this->success();
    }

    /**
     * @param Request $request
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     */
    public function productPrincipal(Request $request, Bug $bug)
    {
        $this->checkPolicy($bug, 'productPrincipal');
        $data = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);
        $this->bugsRepository->productPrincipal($bug, $data['user_id']);
        return $this->success();
    }

    /**
     * @param Request $request
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     */
    public function programPrincipal(Request $request, Bug $bug)
    {
        $this->checkPolicy($bug, 'programPrincipal');
        $data = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);
        $this->bugsRepository->programPrincipal($bug, $data['user_id']);
        return $this->success();
    }

    /**
     * 申请审批
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     */
    public function applyExamine(Bug $bug)
    {
        $this->checkPolicy($bug, 'applyExamine');
        $this->bugsRepository->applyExamine($bug);
        return $this->success();
    }

    /**
     * 撤销审批申请
     * @param Request $request
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     */
    public function applyExamineCancel(Request $request, Bug $bug)
    {
        $this->checkPolicy($bug, 'applyExamineCancel');
        $request->validate(['comment' => 'required|string']);
        $this->bugsRepository->applyExamineCancel($bug);
        return $this->success();
    }

    /**
     * @param Request $request
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidStatusException
     */
    public function follow(Request $request, Bug $bug)
    {
        $this->checkPolicy($bug, 'follow');
        $data = $request->validate([
            'follower_ids'    => 'required|array',
            'follower_ids.*'  => 'required|integer|exists:users,id',
            'expiration_date' => 'required|date',
            'comment'         => 'string',
        ]);
        $this->bugsRepository->follow($bug, $data);
        return $this->success();
    }

    /**
     * 财务审批
     * @param Request $request
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     */
    public function financeExamine(Request $request, Bug $bug)
    {
        $this->checkPolicy($bug, 'financeExamine');
        $data = $request->validate([
            'result'                    => 'required|integer|in:0,1',
            'required_internal_control' => 'integer|in:0,1',
            'comment'                   => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            $this->bugsRepository->financeExamine($bug, $data);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 内控审批
     * @param Request $request
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     */
    public function internalControlExamine(Request $request, Bug $bug)
    {
        $this->checkPolicy($bug, 'internalControlExamine');
        $data = $request->validate([
            'result'  => 'required|integer|in:0,1',
            'comment' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            $this->bugsRepository->internalControlExamine($bug, $data);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 补充信息
     * @param Request $request
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     */
    public function appendInfo(Request $request, Bug $bug)
    {
        $this->checkPolicy($bug, 'appendInfo');
        $data = $request->validate([
            'product_line'        => 'integer|exists:pm_products,id',
            'product_id'          => 'integer|exists:pm_products,id',
            'source_project_id'   => 'integer|exists:pm_projects,id',
            'source_project_name' => 'string',
            'source_demand_id'    => 'integer|exists:pm_demands,id',
            'source_demand_name'  => 'string',
        ]);
        if (empty($data)) return $this->failedWithMessage('补充信息不能全为空！');
        DB::beginTransaction();
        try {
            $this->bugsRepository->appendInfo($bug, $data);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 关闭bug
     * @param Request $request
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     */
    public function close(Request $request, Bug $bug)
    {
        $this->checkPolicy($bug, 'close');
        $data = $request->validate([
            'product_line'        => 'integer|exists:pm_products,id',
            'product_id'          => 'integer|exists:pm_products,id',
            'source_project_id'   => 'integer|exists:pm_projects,id',
            'source_project_name' => 'string',
            'source_demand_id'    => 'integer|exists:pm_demands,id',
            'source_demand_name'  => 'string',
            'comment'             => 'string',
        ]);
        DB::beginTransaction();
        try {
            $this->bugsRepository->close($bug, $data);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 提交处理结果
     * @param BugSubmitResultRequest $request
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitHandleResult(BugSubmitResultRequest $request, Bug $bug)
    {
        $this->checkPolicy($bug, 'submitHandleResult');
        DB::beginTransaction();
        try {
            $this->bugsRepository->submitHandleResult($bug, $request->validated());
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

    /**
     * 撤销提交
     * @param Request $request
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitHandleResultCancel(Request $request, Bug $bug)
    {
        $this->checkPolicy($bug, 'submitHandleResultCancel');
        $this->bugsRepository->submitHandleResultCancel($bug);
        return $this->success();
    }

    /**
     * 更改提交信息
     * @param Request $request
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidStatusException
     */
    public function updateHandleResult(Request $request, Bug $bug)
    {
        $this->checkPolicy($bug, 'updateHandleResult');

        $data = $request->validate([
            'solution' => 'required|string',
            'reason_id' => 'required|integer|exists:pm_bug_reason,id',
            'reason_analyse' => 'string',
            'data_restore' => 'required|integer|between:1,4',
            'data_restore_comment' => 'string',
            'inquiry_progress' => 'string',
        ], [], [
            'solution' => '解决方案',
            'reason_id' => '原因类型',
            'reason_analyse' => '原因类型分析说明',
            'data_restore' => '数据修复情况',
            'data_restore_comment' => '数据修复情况说明',
            'inquiry_progress' => '调查进展',
        ]);
        $this->bugsRepository->updateHandleResult($bug, $data);
        return $this->success();
    }

    /**
     * 复核
     * @param BugReexamineRequest $request
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     */
    public function reexamine(BugReexamineRequest $request, Bug $bug)
    {
        $this->checkPolicy($bug, 'reexamine');
        $this->bugsRepository->reexamine($bug, $request->validated());
        return $this->success();
    }

    /**
     * 产品验收
     * @param Request $request
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     */
    public function acceptPromulgator(Request $request, Bug $bug)
    {
        $this->checkPolicy($bug, 'acceptPromulgator');
        $data = $request->validate([
            'result'  => 'required|in:0,1',
            'media'   => 'array',
            'media.*' => 'file',
        ]);
        $this->bugsRepository->accept($bug, $data, BugAccept::TYPE_PROMULGATOR);
        return $this->success();
    }

    /**
     * 产品验收
     * @param Request $request
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidParameterException
     */
    public function acceptProduct(Request $request, Bug $bug)
    {
        $this->checkPolicy($bug, 'acceptProduct');
        $data = $request->validate([
            'result'  => 'required|in:0,1',
            'media'   => 'array',
            'media.*' => 'file',
        ]);
        $this->bugsRepository->accept($bug, $data, BugAccept::TYPE_PRODUCT);
        return $this->success();
    }

    /**
     * 测试验收
     * @param Request $request
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidParameterException
     */
    public function acceptTest(Request $request, Bug $bug)
    {
        $this->checkPolicy($bug, 'acceptTest');
        $data = $request->validate([
            'result'  => 'required|in:0,1',
            'media'   => 'array',
            'media.*' => 'file',
        ]);
        $this->bugsRepository->accept($bug, $data, BugAccept::TYPE_TEST);
        return $this->success();
    }

    /**
     * 设置处理时限
     * @param Request $request
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     */
    public function expirationDate(Request $request, Bug $bug)
    {
        $this->checkPolicy($bug, 'expirationDate');
        $data = $request->validate([
            'expiration_date' => 'required|date',
        ]);
        $bug->update($data);
        return $this->success();
    }

    /**
     * 开始
     * @param Request $request
     * @param Bug $bug
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidStatusException
     */
    public function start(Request $request, Bug $bug)
    {
        $this->checkPolicy($bug, 'start');
        $this->bugsRepository->start($bug);
        return $this->success();
    }

    /**
     * bug 列表
     * @param Request $request
     * @param BugsListRepository $bugsList
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request, BugsListRepository $bugsList)
    {
        $result = $bugsList->getList($request->input('limit'));
        return $this->successWithData($result);
    }

    /**
     * 导出
     * @param BugExport $export
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(BugExport $export)
    {
        return Excel::download($export, $export->exportFileName());
    }
}
