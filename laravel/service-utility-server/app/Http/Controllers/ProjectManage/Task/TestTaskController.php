<?php

namespace App\Http\Controllers\ProjectManage\Task;

use App\Exceptions\System\InvalidParameterException;
use App\Exceptions\System\InvalidStatusException;
use App\Exports\TestTaskExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectManage\Task\TestTaskStoreRequest;
use App\Http\Requests\ProjectManage\Task\TestTaskUpdateRequest;
use App\ProjectManage\Models\TestSubTask;
use App\ProjectManage\Models\TestTask;
use App\ProjectManage\Repositories\Task\TestTaskListRepository;
use App\ProjectManage\Repositories\Task\TestTaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class TestTaskController extends Controller
{
    /**
     * @var TestTaskRepository
     */
    private $testTask;

    public function __construct(TestTaskRepository $testTask)
    {
        parent::__construct();

        $this->testTask = $testTask;
    }

    /**
     * 测试-发布任务
     * @param TestTaskStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TestTaskStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->testTask->store($request->validated());
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
     * @param TestTaskUpdateRequest $request
     * @param TestTask $task
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function update(TestTaskUpdateRequest $request, TestTask $task)
    {
        $this->checkPolicy($task, 'update');
        DB::beginTransaction();
        try {
            $this->testTask->updateTask($task, $request);
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
     * 测试-设置总任务优先级
     * @param Request $request
     * @param TestTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function priority(Request $request, TestTask $task)
    {
        if ($this->user()->cant('priority', $task)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'priority' => 'required|integer|between:1,5',
        ]);
        $this->testTask->update($task, $data);

        return $this->success();
    }

    /**
     * 测试-更改任务负责人
     * @param Request $request
     * @param TestTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function principal(Request $request, TestTask $task)
    {
        if ($this->user()->cannot('setPrincipal', $task)) {
            throw new InvalidStatusException();
        }
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            $this->testTask->principal($task, $request->user_id);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();

        return $this->success();
    }

    /**
     * @param TestTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPrincipal(TestTask $task)
    {
        $users = $this->testTask->getPrincipal($task);
        return $this->successWithData(compact('users'));
    }

    /**
     * 测试-总任务状态变更日志
     * @param TestTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function logs(TestTask $task)
    {
        return $this->successWithData(['status_logs' => $task->logs()]);
    }

    /**
     * @param TestSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     */
    public function subTaskLogs(TestSubTask $subTask)
    {
        return $this->successWithData(['status_logs' => $subTask->logs()]);
    }

    /**
     * @param Request $request
     * @param TestTask $task
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function expirationDate(Request $request, TestTask $task)
    {
        if ($this->user()->cannot('expirationDate', $task)) {
            throw new InvalidStatusException();
        }
        $request->validate([
            'expiration_date' => 'required|date',
        ]);
        $this->testTask->expirationDate($task, $request->input('expiration_date'));
        return $this->success();
    }

    /**
     * 审核任务
     * @param Request $request
     * @param TestTask $task
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function verify(Request $request, TestTask $task)
    {
        $this->checkPolicy($task, 'verify');
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $this->testTask->verify($task, $data);
        return $this->success();
    }

    /**
     * 更改审核
     * @param Request $request
     * @param TestTask $task
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function verifyUpdate(Request $request, TestTask $task)
    {
        $this->checkPolicy($task, 'verifyUpdate');
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $this->testTask->verifyUpdate($task, $data);
        return $this->success();
    }

    /**
     * 任务详情
     * @param Request $request
     * @param TestTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(Request $request, TestTask $task)
    {
        $result = $this->testTask->details($task);
        return $this->successWithData(['test_task' => $result]);
    }

    /**
     * 批量创建子任务
     * @param Request $request
     * @param TestTask $task
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTask(Request $request, TestTask $task)
    {
        if ($this->user()->cannot('createSubTask', $task)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'subtasks' => 'required|array',
            'subtasks.*.user_id' => 'required|integer|exists:users,id',
//            'subtasks.*.priority' => 'integer|between:1,5',
            'subtasks.*.expiration_date' => 'required|date',
            'subtasks.*.description' => 'string',
        ]);
        $this->testTask->createSubTask($task, $data['subtasks']);

        return $this->success();
    }

    /**
     * 测试-指派任务处理人
     * @param Request $request
     * @param TestTask $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(Request $request, TestTask $task)
    {
        if ($this->user()->cant('setHandler', $task)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'expiration_date' => 'required|date',
            'comment' => 'string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $this->testTask->setHandler($task, $data);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();

        return $this->success();
    }

    /**
     * 测试-开始子任务
     * @param Request $request
     * @param TestSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskStart(Request $request, TestSubTask $subTask)
    {
        if (!$this->user()->can('start', $subTask)) {
            throw new InvalidStatusException();
        }
        DB::beginTransaction();
        try {
            $this->testTask->subTaskStart($subTask);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();

        return $this->success();
    }

    /**
     * 测试-提交子任务
     * @param Request $request
     * @param TestSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskSubmit(Request $request, TestSubTask $subTask)
    {
        if (!$this->user()->can('submit', $subTask)) {
            throw new InvalidStatusException();
        }
        $data = $request->validate([
            'share_address' => 'array',
            'share_address.*' => 'string',
            'media' => 'array',
            'media.*' => 'file',
            'feedback' => 'string',
            'result' => 'required|integer'
        ]);
        DB::beginTransaction();
        try {
            $this->testTask->subTaskSubmit($subTask, $data);
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
     * @param TestSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskSubmitUpdate(Request $request, TestSubTask $subTask)
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
            'feedback' => 'string',
            'result' => 'required|integer',
        ]);
        DB::beginTransaction();
        try {
            $this->testTask->subTaskSubmitUpdate($subTask, $data);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 测试-撤销提交子任务
     * @param Request $request
     * @param TestSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskSubmitCancel(Request $request, TestSubTask $subTask)
    {
        if ($this->user()->cant('submitCancel', $subTask)) {
            throw new InvalidStatusException();
        }
        DB::beginTransaction();
        try {
            $this->testTask->subTaskSubmitCancel($subTask);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 测试-撤销子任务
     * @param Request $request
     * @param TestSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskRevocation(Request $request, TestSubTask $subTask)
    {
        if (!$this->user()->can('revocation', $subTask)) {
            throw new InvalidStatusException();
        }
        $this->testTask->subTaskRevocation($subTask);
        return $this->success();
    }

    /**
     * 测试-暂停子任务
     * @param Request $request
     * @param TestSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskPause(Request $request, TestSubTask $subTask)
    {
        if (!$this->user()->can('pause', $subTask)) {
            throw new InvalidStatusException();
        }
        DB::beginTransaction();
        try {
            $this->testTask->subTaskPause($subTask);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return $this->success();
    }

    /**
     * 测试-确认完成子任务
     * @param Request $request
     * @param TestSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskComplete(Request $request, TestSubTask $subTask)
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
            $this->testTask->subTaskComplete($subTask, $data);
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
     * @param TestSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskExpirationDate(Request $request, TestSubTask $subTask)
    {
        if (!$this->user()->can('expirationDate', $subTask)) {
            throw new  InvalidStatusException();
        }
        $request->validate([
            'expiration_date' => 'required|date',
        ]);
        $data = $request->only('expiration_date');
        $subTask->update($data);
        if ($subTask->is_main == 1) {
            $subTask->task()->first()->update($data);
        }
        return $this->success();
    }

    /**
     * @param Request $request
     * @param TestSubTask $subTask
     * @return \Illuminate\Http\JsonResponse
     * @throws InvalidStatusException
     */
    public function subTaskPriority(Request $request, TestSubTask $subTask)
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
     * 测试任务列表
     * @param Request $request
     * @param TestTaskListRepository $taskList
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request, TestTaskListRepository $taskList)
    {
        $result = $taskList->getList($request->limit);
        return $this->successWithData($result);
    }

    /**
     * @param TestTaskExport $export
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel(TestTaskExport $export)
    {
        return Excel::download($export, $export->exportFileName());
    }
}
