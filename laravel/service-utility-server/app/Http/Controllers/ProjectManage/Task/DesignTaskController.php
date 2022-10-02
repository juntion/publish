<?php

namespace App\Http\Controllers\ProjectManage\Task;

use App\Exceptions\System\InvalidParameterException;
use App\Exceptions\System\InvalidStatusException;
use App\Exports\DesignTaskExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectManage\Task\DesignStoreRequest;
use App\Http\Requests\ProjectManage\Task\DesignTaskReviewRequest;
use App\Http\Requests\ProjectManage\Task\DesignTaskSequenceRequest;
use App\Http\Requests\ProjectManage\Task\DesignTaskUpdateRequest;
use App\Http\Requests\ProjectManage\Task\DesignTaskVerifyRequest;
use App\ProjectManage\Models\DesignPart;
use App\ProjectManage\Models\DesignSubTask;
use App\ProjectManage\Models\DesignTask;
use App\ProjectManage\Repositories\Task\DesignTaskRepository;
use App\ProjectManage\Repositories\Task\DesignTaskListRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class DesignTaskController extends Controller
{
    /**
     * @var DesignTaskRepository
     */
    private $designTask;

    public function __construct(DesignTaskRepository $designTask)
    {
        parent::__construct();

        $this->designTask = $designTask;
    }

    /**
     * 发布任务
     * @param DesignStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DesignStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->designTask->store($request);
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
     * 编辑任务
     * @param DesignTaskUpdateRequest $request
     * @param DesignTask $task
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function update(DesignTaskUpdateRequest $request, DesignTask $task)
    {
        $this->checkPolicy($task, 'update');
        DB::beginTransaction();
        try {
            $this->designTask->updateTask($task, $request);
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
     * 设置设计总任务优先级
     * @param Request $request
     * @param DesignTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function priority(Request $request, DesignTask $task)
    {
        if ($this->user()->cant('priority', $task)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'priority' => 'required|integer|between:1,5',
        ]);
        $this->designTask->update($task, $data);

        return $this->success();
    }

    /**
     * 设计-更改任务负责人
     * @param Request $request
     * @param DesignTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function principal(Request $request, DesignTask $task)
    {
        if ($this->user()->cant('principal', $task)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'team_id' => 'required|integer|exists:pm_teams,id',
        ]);
        DB::beginTransaction();
        try {
            $this->designTask->principal($task, $data['team_id']);
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
     * 设计-获取该任务更新负责人
     * @param DesignTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPrincipal(DesignTask $task)
    {
        $users = $this->designTask->getPrincipal($task);
        return $this->successWithData(compact('users'));
    }

    /**
     * 设计走查
     * @param DesignTaskReviewRequest $request
     * @param DesignTask $task
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function review(DesignTaskReviewRequest $request, DesignTask $task)
    {
        $this->designTask->review($task, $request->validated());

        return $this->success();
    }

    /**
     * 设计-审核任务（生成环节）
     * @param Request $request
     * @param DesignTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(DesignTaskVerifyRequest $request, DesignTask $task)
    {
        DB::beginTransaction();

        try {
            $this->designTask->verify($task, $request->validated());
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
     * 更改设计环节顺序
     * @param Request $request
     * @param DesignTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function sequence(DesignTaskSequenceRequest $request, DesignTask $task)
    {
        DB::beginTransaction();
        try {
            $this->designTask->sequence($task, $request->validated());
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            if ($e instanceof InvalidStatusException || $e instanceof InvalidParameterException) {
                return $this->failedWithMessage($e->getMessage());
            }
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 设计-总任务状态变更日志
     * @param DesignTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function logs(DesignTask $task)
    {
        return $this->successWithData(['status_logs' => $task->logs()]);
    }

    /**
     * @param DesignPart $part
     * @return \Illuminate\Http\JsonResponse
     */
    public function partLogs(DesignPart $part)
    {
        return $this->successWithData(['status_logs' => $part->logs()]);
    }

    /**
     * @param DesignSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     */
    public function subTaskLogs(DesignSubtask $subTask)
    {
        return $this->successWithData(['status_logs' => $subTask->logs()]);
    }

    /**
     * 设计-`更改任务预计交付日期
     * @param DesignTask $task
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function expirationDate(DesignTask $task, Request $request)
    {
        if ($this->user()->cannot('expirationDate', $task)) {
            throw new InvalidStatusException();
        }
        $request->validate([
            'expiration_date' => 'required|date',
        ]);
        $this->designTask->expirationDate($task, $request->input('expiration_date'));
        return $this->success();
    }

    /**
     * @param DesignTask $task
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(DesignTask $task, Request $request)
    {
        $result = $this->designTask->details($task);
        return $this->successWithData(['design_task' => $result]);
    }

    /**
     * 设计-设置任务处理人
     * @param Request $request
     * @param DesignPart $part
     * @return \Illuminate\Http\JsonResponse
     */
    public function partHandler(Request $request, DesignPart $part)
    {
        if ($this->user()->cannot('setPartHandler', $part)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'expiration_date' => 'required|date',
            'comment' => 'string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $this->designTask->partHandler($part, $data);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();

        return $this->success();
    }

    /**
     * 设计-批量创建环节子任务
     * @param Request $request
     * @param DesignPart $part
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTask(Request $request, DesignPart $part)
    {
        if ($this->user()->cannot('createSubTask', $part)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'subtasks' => 'required|array',
            'subtasks.*.user_id' => 'required|integer|exists:users,id',
            'subtasks.*.expiration_date' => 'required|date',
            'subtasks.*.description' => 'string',
//            'subtasks.*.priority' => 'integer|between:1,5',
        ]);
        $this->designTask->subTask($part, $data['subtasks']);

        return $this->success();
    }

    /**
     * 设计-提交环节子任务
     * @param Request $request
     * @param DesignSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function subTaskSubmit(Request $request, DesignSubTask $subTask)
    {
        if (!$this->user()->can('submit', $subTask)) {
            throw new  InvalidStatusException();
        }
        $data = $request->validate([
            'share_address' => 'array',
            'share_address.*' => 'string',
            'media' => 'array',
            'media.*' => 'file',
            'comment' => 'string|max:255',
            'release_type' => 'integer|between:0,2',
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
            'comment' => '备注',
            'release_type' => '发版类型',
            'branch_name' => '分支名',
            'has_sql' => 'SQL',
            'release_version_id' => '纳入版本号',
            'stress_test' => '压力测试',
            'release_comment' => '发版说明',
        ]);
        DB::beginTransaction();
        try {
            $this->designTask->subTaskSubmit($subTask, $data);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 更新提交
     * @param Request $request
     * @param DesignSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskSubmitUpdate(Request $request, DesignSubTask $subTask)
    {
        if (!$this->user()->can('submitUpdate', $subTask)) {
            throw new  InvalidStatusException();
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
            $this->designTask->subTaskSubmitUpdate($subTask, $data);
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
     * @param Request $request
     * @param DesignSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskSubmitCancel(Request $request, DesignSubTask $subTask)
    {
        if ($this->user()->cant('submitCancel', $subTask)) {
            throw new  InvalidStatusException();
        }
        DB::beginTransaction();
        try {
            $this->designTask->subTaskSubmitCancel($subTask);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 设计-开始环节子任务
     * @param Request $request
     * @param DesignSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     */
    public function subTaskStart(Request $request, DesignSubTask $subTask)
    {
        if (!$this->user()->can('start', $subTask)) {
            throw new  InvalidStatusException();
        }
        $request->validate(['comment' => 'string|max:255']);
        DB::beginTransaction();
        try {
            $this->designTask->subTaskStart($subTask);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 设计-暂停环节子任务
     * @param Request $request
     * @param DesignSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     */
    public function subTaskPause(Request $request, DesignSubTask $subTask)
    {
        if (!$this->user()->can('pause', $subTask)) {
            throw new  InvalidStatusException();
        }
        $request->validate(['comment' => 'string|max:255']);
        DB::beginTransaction();
        try {
            $this->designTask->subTaskPause($subTask);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 撤销子任务
     * @param Request $request
     * @param DesignSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     */
    public function subTaskRevocation(Request $request, DesignSubTask $subTask)
    {
        if (!$this->user()->can('revocation', $subTask)) {
            throw new  InvalidStatusException();
        }
        $request->validate(['comment' => 'string|max:255']);
        $this->designTask->subTaskRevocation($subTask);

        return $this->success();
    }

    /**
     * 确认完成环节子任务
     * @param Request $request
     * @param DesignSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskComplete(Request $request, DesignSubTask $subTask)
    {
        if (!$this->user()->can('complete', $subTask)) {
            throw new  InvalidStatusException();
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
            $this->designTask->subTaskComplete($subTask, $data);
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
     * 设计-更改子任务交付日期
     * @param Request $request
     * @param DesignSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     */
    public function subTaskExpirationDate(Request $request, DesignSubTask $subTask)
    {
        if (!$this->user()->can('expirationDate', $subTask)) {
            throw new  InvalidStatusException();
        }
        $request->validate([
            'expiration_date' => 'required|date',
        ]);
        $subTask->update($request->only('expiration_date'));
        return $this->success();
    }

    /**
     * 设计-设置子任务优先级
     * @param Request $request
     * @param DesignSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskPriority(Request $request, DesignSubTask $subTask)
    {
        if (!$this->user()->can('priority', $subTask)) {
            throw new InvalidStatusException();
        }
        $request->validate([
            'priority' => 'required|integer|between:1,5',
        ]);
        $subTask->update($request->only('priority'));
        return $this->success();
    }

    /**
     * 任务列表
     * @param Request $request
     * @param DesignTaskListRepository $taskList
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request, DesignTaskListRepository $taskList)
    {
        $result = $taskList->getList($request->input('limit'));
        return $this->successWithData($result);
    }

    /**
     * @param DesignTaskExport $export
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel(DesignTaskExport $export)
    {
        return Excel::download($export, $export->exportFileName());
    }

    /**
     * @param Request $request
     * @param DesignSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskUpdateVersion(Request $request, DesignSubTask $subTask)
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
            $this->designTask->subTaskUpdateVersion($subTask, $data);
        } catch (\Exception $e) {
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->success();
    }
}
