<?php

namespace App\Http\Controllers\ProjectManage\Task;

use App\Exceptions\System\InvalidParameterException;
use App\Exceptions\System\InvalidStatusException;
use App\Exports\MobileTaskExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectManage\Task\MobileTaskStoreRequest;
use App\Http\Requests\ProjectManage\Task\MobileTaskUpdateRequest;
use App\ProjectManage\Models\MobileSubTask;
use App\ProjectManage\Models\MobileTask;
use App\ProjectManage\Repositories\Task\MobileTaskListRepository;
use App\ProjectManage\Repositories\Task\MobileTaskRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MobileTaskController extends Controller
{
    /**
     * @var MobileTaskRepository
     */
    private $mobileTask;

    public function __construct(MobileTaskRepository $mobileTask)
    {
        parent::__construct();

        $this->mobileTask = $mobileTask;
    }

    /**
     * @param MobileTaskStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MobileTaskStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->mobileTask->store($request->validated());
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
     * @param MobileTaskUpdateRequest $request
     * @param MobileTask $task
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function update(MobileTaskUpdateRequest $request, MobileTask $task)
    {
        $this->checkPolicy($task, 'update');
        DB::beginTransaction();
        try {
            $this->mobileTask->updateTask($task, $request);
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
     * @param MobileTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function priority(Request $request, MobileTask $task)
    {
        if ($this->user()->cant('priority', $task)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'priority' => 'required|integer|between:1,5',
        ]);
        $this->mobileTask->update($task, $data);

        return $this->success();
    }

    /**
     * @param MobileTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPrincipal(MobileTask $task)
    {
        $users = $this->mobileTask->getPrincipal($task);
        return $this->successWithData(compact('users'));
    }

    /**
     * @param MobileTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function logs(MobileTask $task)
    {
        return $this->successWithData(['status_logs' => $task->logs()]);
    }

    /**
     * @param MobileSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     */
    public function subTaskLogs(MobileSubTask $subTask)
    {
        return $this->successWithData(['status_logs' => $subTask->logs()]);
    }

    /**
     * @param MobileTask $task
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function expirationDate(MobileTask $task, Request $request)
    {
        if ($this->user()->cannot('expirationDate', $task)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'expiration_date' => 'required|date',
            'standard_workload' => 'required|numeric',
            'adjust_reason' => 'string',
        ]);
        $this->mobileTask->expirationDate($task, $data);
        return $this->success();
    }

    /**
     * @param MobileTask $task
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function verify(MobileTask $task, Request $request)
    {
        $this->checkPolicy($task, 'verify');
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'level' => 'in:S,A,B,C,D',
        ]);
        DB::transaction(function () use ($task, $data) {
            $this->mobileTask->verify($task, $data);
        });
        return $this->success();
    }

    /**
     * @param MobileTask $task
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function verifyUpdate(MobileTask $task, Request $request)
    {
        $this->checkPolicy($task, 'verifyUpdate');
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'level' => 'in:S,A,B,C,D',
        ]);
        DB::transaction(function () use ($task, $data) {
            $this->mobileTask->verifyUpdate($task, $data);
        });
        return $this->success();
    }

    /**
     * @param MobileTask $task
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(MobileTask $task, Request $request)
    {
        $result = $this->mobileTask->details($task);
        return $this->successWithData(['mobile_task' => $result]);
    }

    /**
     * @param Request $request
     * @param MobileTask $task
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTask(Request $request, MobileTask $task)
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
        $this->mobileTask->createSubTask($task, $data['subtasks']);

        return $this->success();
    }

    /**
     * @param Request $request
     * @param MobileTask $task
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function handler(Request $request, MobileTask $task)
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
            $this->mobileTask->setHandler($task, $data);
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
     * @param MobileSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskStart(Request $request, MobileSubTask $subTask)
    {
        if (!$this->user()->can('start', $subTask)) {
            throw new InvalidStatusException();
        }
        DB::beginTransaction();
        try {
            $this->mobileTask->subTaskStart($subTask);
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
     * @param MobileSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskSubmit(Request $request, MobileSubTask $subTask)
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
            $this->mobileTask->subTaskSubmit($subTask, $data);
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
     * @param MobileSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskSubmitUpdate(Request $request, MobileSubTask $subTask)
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
            $this->mobileTask->subTaskSubmitUpdate($subTask, $data);
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
     * @param MobileSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskSubmitCancel(Request $request, MobileSubTask $subTask)
    {
        if ($this->user()->cant('submitCancel', $subTask)) {
            throw new InvalidStatusException();
        }
        DB::beginTransaction();
        try {
            $this->mobileTask->subTaskSubmitCancel($subTask);
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
     * @param MobileSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskRevocation(Request $request, MobileSubTask $subTask)
    {
        if (!$this->user()->can('revocation', $subTask)) {
            throw new InvalidStatusException();
        }
        $this->mobileTask->subTaskRevocation($subTask);
        return $this->success();
    }

    /**
     * @param Request $request
     * @param MobileSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskPause(Request $request, MobileSubTask $subTask)
    {
        if (!$this->user()->can('pause', $subTask)) {
            throw new InvalidStatusException();
        }
        DB::beginTransaction();
        try {
            $this->mobileTask->subTaskPause($subTask);
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
     * @param MobileSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskComplete(Request $request, MobileSubTask $subTask)
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
            $this->mobileTask->subTaskComplete($subTask, $data);
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
     * @param MobileSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskExpirationDate(Request $request, MobileSubTask $subTask)
    {
        if (!$this->user()->can('expirationDate', $subTask)) {
            throw new  InvalidStatusException();
        }
        $data = $request->validate([
            'expiration_date' => 'required|date',
            'standard_workload' => 'required|numeric',
            'adjust_reason' => 'string',
        ]);

        $this->mobileTask->subTaskExpirationDate($subTask, $data);
        return $this->success();
    }

    /**
     * @param Request $request
     * @param MobileSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskPriority(Request $request, MobileSubTask $subTask)
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
     * @param MobileSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskUpdateVersion(Request $request, MobileSubTask $subTask)
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
            $this->mobileTask->subTaskUpdateVersion($subTask, $data);
        } catch (\Exception $e) {
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->success();
    }

    /**
     * @param Request $request
     * @param MobileTaskListRepository $mobilrTask
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request, MobileTaskListRepository $mobilrTask)
    {
        $result = $mobilrTask->getList($request->limit);

        return $this->successWithData($result);
    }

    /**
     * @param MobileTaskExport $export
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel(MobileTaskExport $export)
    {
        return Excel::download($export, $export->exportFileName());
    }
}
