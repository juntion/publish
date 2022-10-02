<?php

namespace App\Http\Controllers\ProjectManage\Task;

use App\Exceptions\System\InvalidParameterException;
use App\Exceptions\System\InvalidStatusException;
use App\Exports\DevTaskExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectManage\Task\DevTaskStoreRequest;
use App\Http\Requests\ProjectManage\Task\DevTaskUpdateRequest;
use App\ProjectManage\Models\DevSubTask;
use App\ProjectManage\Models\DevTask;
use App\ProjectManage\Repositories\Task\DevTaskListRepository;
use App\ProjectManage\Repositories\Task\DevTaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class DevTaskController extends Controller
{
    /**
     * @var DevTaskRepository
     */
    private $devTask;

    public function __construct(DevTaskRepository $devTask)
    {
        parent::__construct();

        $this->devTask = $devTask;
    }

    /**
     * 开发-发布任务
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DevTaskStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->devTask->store($request->validated());
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
     * @param DevTask $task
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function update(DevTaskUpdateRequest $request, DevTask $task)
    {
        $this->checkPolicy($task, 'update');
        DB::beginTransaction();
        try {
            $this->devTask->updateTask($task, $request);
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
     * @param DevTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function priority(Request $request, DevTask $task)
    {
        if ($this->user()->cant('priority', $task)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'priority' => 'required|integer|between:1,5',
        ]);
        $this->devTask->update($task, $data);

        return $this->success();
    }

    /**
     * 开发-更改任务负责人
     * @param Request $request
     * @param DevTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function principal(Request $request, DevTask $task)
    {
        if ($this->user()->cannot('setPrincipal', $task)) {
            throw new InvalidStatusException();
        }
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'level' => 'required|string|in:S,A,B,C,D',
        ]);

        DB::beginTransaction();
        try {
            $this->devTask->principal($task, $request);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();

        return $this->success();
    }

    /**
     * @param DevTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPrincipal(DevTask $task)
    {
        $users = $this->devTask->getPrincipal($task);
        return $this->successWithData(compact('users'));
    }

    /**
     * 开发-总任务状态变更日志
     * @param DevTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function logs(DevTask $task)
    {
        return $this->successWithData(['status_logs' => $task->logs()]);
    }

    /**
     * @param DevSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     */
    public function subTaskLogs(DevSubTask $subTask)
    {
        return $this->successWithData(['status_logs' => $subTask->logs()]);
    }

    /**
     * 开发-更改任务预计交付日期
     * @param DevTask $task
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function expirationDate(DevTask $task, Request $request)
    {
        if ($this->user()->cannot('expirationDate', $task)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'expiration_date' => 'required|date',
            'standard_workload' => 'required|numeric',
            'adjust_reason' => 'string',
        ]);
        $this->devTask->expirationDate($task, $data);
        return $this->success();
    }

    /**
     * 审核任务
     * @param DevTask $task
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function verify(DevTask $task, Request $request)
    {
        $this->checkPolicy($task, 'verify');
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'level' => 'in:S,A,B,C,D',
        ]);
        $this->devTask->verify($task, $data);
        return $this->success();
    }

    /**
     * 更改审核
     * @param DevTask $task
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function verifyUpdate(DevTask $task, Request $request)
    {
        $this->checkPolicy($task, 'verifyUpdate');
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'level' => 'in:S,A,B,C,D',
        ]);
        $this->devTask->verifyUpdate($task, $data);
        return $this->success();
    }

    /**
     * 任务详情
     * @param DevTask $task
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(DevTask $task, Request $request)
    {
        $result = $this->devTask->details($task);
        return $this->successWithData(['dev_task' => $result]);
    }

    /**
     * 开发 - 批量创建子任务 (添加次要跟进人)
     * @param Request $request
     * @param DevTask $task
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTask(Request $request, DevTask $task)
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
        $this->devTask->createSubTask($task, $data['subtasks']);

        return $this->success();
    }

    /**
     * 开发-指派任务处理人(主跟进人)
     * @param Request $request
     * @param DevTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(Request $request, DevTask $task)
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
            $this->devTask->setHandler($task, $data);
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
     * 开发-开始子任务
     * @param Request $request
     * @param DevSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskStart(Request $request, DevSubTask $subTask)
    {
        if (!$this->user()->can('start', $subTask)) {
            throw new InvalidStatusException();
        }
        DB::beginTransaction();
        try {
            $this->devTask->subTaskStart($subTask);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 开发-提交子任务
     * @param Request $request
     * @param DevSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskSubmit(Request $request, DevSubTask $subTask)
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
            $this->devTask->subTaskSubmit($subTask, $data);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 更新提交信息
     * @param Request $request
     * @param DevSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskSubmitUpdate(Request $request, DevSubTask $subTask)
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
            $this->devTask->subTaskSubmitUpdate($subTask, $data);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 开发-撤销提交子任务
     * @param Request $request
     * @param DevSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskSubmitCancel(Request $request, DevSubTask $subTask)
    {
        if ($this->user()->cant('submitCancel', $subTask)) {
            throw new InvalidStatusException();
        }
        DB::beginTransaction();
        try {
            $this->devTask->subTaskSubmitCancel($subTask);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 开发-撤销子任务
     * @param Request $request
     * @param DevSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskRevocation(Request $request, DevSubTask $subTask)
    {
        if (!$this->user()->can('revocation', $subTask)) {
            throw new InvalidStatusException();
        }
        $this->devTask->subTaskRevocation($subTask);
        return $this->success();
    }

    /**
     * 开发-暂停子任务
     * @param Request $request
     * @param DevSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskPause(Request $request, DevSubTask $subTask)
    {
        if (!$this->user()->can('pause', $subTask)) {
            throw new InvalidStatusException();
        }
        DB::beginTransaction();
        try {
            $this->devTask->subTaskPause($subTask);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 开发-确认完成子任务
     * @param Request $request
     * @param DevSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskComplete(Request $request, DevSubTask $subTask)
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
            $this->devTask->subTaskComplete($subTask, $data);
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
     * @param DevSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskExpirationDate(Request $request, DevSubTask $subTask)
    {
        if (!$this->user()->can('expirationDate', $subTask)) {
            throw new  InvalidStatusException();
        }
        $data = $request->validate([
            'expiration_date' => 'required|date',
            'standard_workload' => 'required|numeric',
            'adjust_reason' => 'string',
        ]);

        $this->devTask->subTaskExpirationDate($subTask, $data);
        return $this->success();
    }

    /**
     * @param Request $request
     * @param DevSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskPriority(Request $request, DevSubTask $subTask)
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
     * 开发-任务列表
     * @param Request $request
     * @param DevTaskListRepository $devTask
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request, DevTaskListRepository $devTask)
    {
        $result = $devTask->getList($request->limit);

        return $this->successWithData($result);
    }

    /**
     * @param DevTaskExport $export
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel(DevTaskExport $export)
    {
        return Excel::download($export, $export->exportFileName());
    }

    /**
     * @param Request $request
     * @param DevSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskUpdateVersion(Request $request, DevSubTask $subTask)
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
            $this->devTask->subTaskUpdateVersion($subTask, $data);
        } catch (\Exception $e) {
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->success();
    }

    /**
     * 根据预计交付日期计算标准工作量
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWorkload(Request $request)
    {
        $request->validate([
            'start_date' => 'date_format:Y-m-d',
            'expiration_date' => 'required|date_format:Y-m-d',
        ]);
        $result = $this->devTask->getWorkload($request);
        return $this->successWithData($result);
    }

    /**
     * 根据工作量计算 等级、系数
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidParameterException
     */
    public function getAppraisalData(Request $request)
    {
        $request->validate([
            'workload' => 'required|numeric',
        ]);
        $result = $this->devTask->subTaskAppraisalData($request->workload);
        return $this->successWithData($result);
    }
}
