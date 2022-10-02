<?php

namespace App\Http\Controllers\ProjectManage\Task;

use App\Exceptions\System\InvalidParameterException;
use App\Exceptions\System\InvalidStatusException;
use App\Exports\FrontendTaskExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectManage\Task\FrontendTaskStoreRequest;
use App\Http\Requests\ProjectManage\Task\FrontendTaskUpdateRequest;
use App\ProjectManage\Models\FrontendSubTask;
use App\ProjectManage\Models\FrontendTask;
use App\ProjectManage\Repositories\Task\FrontendTaskListRepository;
use App\ProjectManage\Repositories\Task\FrontendTaskRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class FrontendTaskController extends Controller
{
    /**
     * @var FrontendTaskRepository
     */
    private $frontendTask;

    public function __construct(FrontendTaskRepository $frontendTask)
    {
        parent::__construct();

        $this->frontendTask = $frontendTask;
    }

    /**
     * @param FrontendTaskStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FrontendTaskStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->frontendTask->store($request->validated());
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
     * @param FrontendTaskUpdateRequest $request
     * @param FrontendTask $task
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function update(FrontendTaskUpdateRequest $request, FrontendTask $task)
    {
        $this->checkPolicy($task, 'update');
        DB::beginTransaction();
        try {
            $this->frontendTask->updateTask($task, $request);
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
     * 开发-设置总任务优先级
     * @param Request $request
     * @param FrontendTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function priority(Request $request, FrontendTask $task)
    {
        if ($this->user()->cant('priority', $task)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'priority' => 'required|integer|between:1,5',
        ]);
        $this->frontendTask->update($task, $data);

        return $this->success();
    }

    /**
     * @param FrontendTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPrincipal(FrontendTask $task)
    {
        $users = $this->frontendTask->getPrincipal($task);
        return $this->successWithData(compact('users'));
    }

    /**
     * @param FrontendTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function logs(FrontendTask $task)
    {
        return $this->successWithData(['status_logs' => $task->logs()]);
    }

    /**
     * @param FrontendSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     */
    public function subTaskLogs(FrontendSubTask $subTask)
    {
        return $this->successWithData(['status_logs' => $subTask->logs()]);
    }

    /**
     * @param FrontendTask $task
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function expirationDate(FrontendTask $task, Request $request)
    {
        if ($this->user()->cannot('expirationDate', $task)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'expiration_date' => 'required|date',
            'standard_workload' => 'required|numeric',
            'adjust_reason' => 'string',
        ]);
        $this->frontendTask->expirationDate($task, $data);
        return $this->success();
    }

    /**
     * @param FrontendTask $task
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function verify(FrontendTask $task, Request $request)
    {
        $this->checkPolicy($task, 'verify');
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'level' => 'in:S,A,B,C,D',
        ]);
        DB::transaction(function () use ($task, $data) {
            $this->frontendTask->verify($task, $data);
        });
        return $this->success();
    }

    /**
     * @param FrontendTask $task
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function verifyUpdate(FrontendTask $task, Request $request)
    {
        $this->checkPolicy($task, 'verifyUpdate');
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'level' => 'in:S,A,B,C,D',
        ]);
        DB::transaction(function () use ($task, $data) {
            $this->frontendTask->verifyUpdate($task, $data);
        });
        return $this->success();
    }

    /**
     * @param FrontendTask $task
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(FrontendTask $task, Request $request)
    {
        $result = $this->frontendTask->details($task);
        return $this->successWithData(['frontend_task' => $result]);
    }

    /**
     * @param Request $request
     * @param FrontendTask $task
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTask(Request $request, FrontendTask $task)
    {
        if ($this->user()->cannot('createSubTask', $task)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'subtasks' => 'required|array',
            'subtasks.*.user_id' => 'required|integer|exists:users,id',
            'subtasks.*.expiration_date' => 'required|date',
            'subtasks.*.description' => 'string',
            'subtasks.*.standard_workload' => 'required|numeric',
            'subtasks.*.adjust_reason' => 'string',
        ]);
        $this->frontendTask->createSubTask($task, $data['subtasks']);

        return $this->success();
    }

    /**
     * @param Request $request
     * @param FrontendTask $task
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function handler(Request $request, FrontendTask $task)
    {
        if ($this->user()->cant('setHandler', $task)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'expiration_date' => 'required|date',
            'comment' => 'string|max:255',
            'standard_workload' => 'required|numeric',
            'adjust_reason' => 'string',
        ]);
        DB::beginTransaction();
        try {
            $this->frontendTask->setHandler($task, $data);
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e instanceof InvalidParameterException) {
                return $this->failedWithMessage($e->getMessage());
            }
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * @param Request $request
     * @param FrontendSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskStart(Request $request, FrontendSubTask $subTask)
    {
        if (!$this->user()->can('start', $subTask)) {
            throw new InvalidStatusException();
        }
        DB::beginTransaction();
        try {
            $this->frontendTask->subTaskStart($subTask);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * @param Request $request
     * @param FrontendSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskSubmit(Request $request, FrontendSubTask $subTask)
    {
        if (!$this->user()->can('submit', $subTask)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'share_address' => 'array',
            'share_address.*' => 'string',
            'media' => 'array',
            'media.*' => 'file',
            'release_type' => 'required|integer|between:0,2',
            'branch_name' => 'string',
            'has_sql' => 'integer|between:0,1',
            'release_version_id' => 'integer|exists:pm_release_versions,id',
            'stress_test' => 'integer|between:0,1',
            'release_comment' => 'string|max:255',
        ], [], [
            'share_address' => 'URL/共享地址',
            'share_address.*' => 'URL/共享地址',
            'media' => '附件',
            'media.*' => '附件',
            'release_type' => '发版类型',
            'branch_name' => '分支名',
            'has_sql' => 'SQL',
            'release_version_id' => '纳入版本号',
            'stress_test' => '压力测试',
            'release_comment' => '发版说明',
        ]);
        DB::beginTransaction();
        try {
            $this->frontendTask->subTaskSubmit($subTask, $data);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * @param Request $request
     * @param FrontendSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskSubmitUpdate(Request $request, FrontendSubTask $subTask)
    {
        if (!$this->user()->can('submitUpdate', $subTask)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'share_address' => 'array',
            'share_address.*' => 'string',
            'new_media' => 'array',
            'new_media.*' => 'file',
            'old_media' => 'array',
            'old_media.*' => 'integer|exists:media,id',
            'comment' => 'string|max:255',
        ]);
        DB::beginTransaction();
        try {
            $this->frontendTask->subTaskSubmitUpdate($subTask, $data);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * @param Request $request
     * @param FrontendSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskSubmitCancel(Request $request, FrontendSubTask $subTask)
    {
        if ($this->user()->cant('submitCancel', $subTask)) {
            throw new InvalidStatusException();
        }
        DB::beginTransaction();
        try {
            $this->frontendTask->subTaskSubmitCancel($subTask);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * @param Request $request
     * @param FrontendSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskRevocation(Request $request, FrontendSubTask $subTask)
    {
        if (!$this->user()->can('revocation', $subTask)) {
            throw new InvalidStatusException();
        }
        $this->frontendTask->subTaskRevocation($subTask);
        return $this->success();
    }

    /**
     * @param Request $request
     * @param FrontendSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskPause(Request $request, FrontendSubTask $subTask)
    {
        if (!$this->user()->can('pause', $subTask)) {
            throw new InvalidStatusException();
        }
        DB::beginTransaction();
        try {
            $this->frontendTask->subTaskPause($subTask);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * @param Request $request
     * @param FrontendSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskComplete(Request $request, FrontendSubTask $subTask)
    {
        if (!$this->user()->can('complete', $subTask)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'result' => 'required|integer|between:0,1',
            'comment' => 'string|max:255',
            'finish_type' => 'integer',
            'difference_reason' => 'string',
        ], [], [
            'result' => '验收结果',
            'comment' => '备注',
            'finish_type' => '完成情况',
            'difference_reason' => '差异原因说明',
        ]);
        DB::beginTransaction();
        try {
            $this->frontendTask->subTaskComplete($subTask, $data);
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
     * @param Request $request
     * @param FrontendSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskExpirationDate(Request $request, FrontendSubTask $subTask)
    {
        if (!$this->user()->can('expirationDate', $subTask)) {
            throw new  InvalidStatusException();
        }
        $data = $request->validate([
            'expiration_date' => 'required|date',
            'standard_workload' => 'required|numeric',
            'adjust_reason' => 'string',
        ]);

        $this->frontendTask->subTaskExpirationDate($subTask, $data);
        return $this->success();
    }

    /**
     * @param Request $request
     * @param FrontendSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskPriority(Request $request, FrontendSubTask $subTask)
    {
        if (!$this->user()->can('priority', $subTask)) {
            throw new  InvalidStatusException();
        }
        $request->validate([
            'priority' => 'required|integer|between:1,5',
        ]);
        $data = $request->only('priority');
        $subTask->update($data);
        if ($subTask->is_main == 1) {
            $subTask->task()->first()->update($data);
        }
        return $this->success();
    }

    /**
     * @param Request $request
     * @param FrontendSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskUpdateVersion(Request $request, FrontendSubTask $subTask)
    {
        $this->checkPolicy($subTask, 'updateVersion');
        $data = $request->validate([
            'release_type' => 'required|integer|between:0,2',
            'branch_name' => 'string',
            'has_sql' => 'integer|between:0,1',
            'release_version_id' => 'integer|exists:pm_release_versions,id',
            'stress_test' => 'integer|between:0,1',
            'release_comment' => 'string|max:255',
        ], [], [
            'release_type' => '发版类型',
            'branch_name' => '分支名',
            'has_sql' => 'SQL',
            'release_version_id' => '纳入版本号',
            'stress_test' => '压力测试',
            'release_comment' => '发版说明',
        ]);
        try {
            $this->frontendTask->subTaskUpdateVersion($subTask, $data);
        } catch (\Exception $e) {
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->success();
    }

    /**
     * @param Request $request
     * @param FrontendTaskListRepository $frontendTask
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request, FrontendTaskListRepository $frontendTask)
    {
        $result = $frontendTask->getList($request->limit);

        return $this->successWithData($result);
    }

    /**
     * @param FrontendTaskExport $export
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel(FrontendTaskExport $export)
    {
        return Excel::download($export, $export->exportFileName());
    }
}
