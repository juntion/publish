<?php

namespace App\ProjectManage\Repositories\Task;

use App\Enums\ProjectManage\DemandLinksType;
use App\Enums\ProjectManage\DemandStatus;
use App\Enums\ProjectManage\DesignTaskStatus;
use App\Enums\ProjectManage\DevTaskStatus;
use App\Enums\ProjectManage\ProductStatus;
use App\Enums\ProjectManage\TeamType;
use App\Enums\ProjectManage\TestSubTaskStatus;
use App\Enums\ProjectManage\TestTaskStatus;
use App\Events\PM\Task\TaskSetHandler;
use App\Events\PM\Task\TaskSubmit;
use App\Exceptions\System\InvalidParameterException;
use App\Models\Position;
use App\Models\User;
use App\ProjectManage\Models\Product;
use App\ProjectManage\Models\Team;
use App\ProjectManage\Models\TestSubTask;
use App\ProjectManage\Models\TestTask;
use App\ProjectManage\Repositories\DropDownTaskRepository;
use App\ProjectManage\Repositories\TeamRepository;
use App\Traits\Task\TaskFinishTrait;
use App\Traits\Task\TaskMediaTrait;
use App\Traits\Task\TaskRepositoryTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TestTaskRepository
{
    use TaskMediaTrait, TaskFinishTrait, TaskRepositoryTrait;

    protected $teams;
    protected $dropDownTask;

    public function __construct(TeamRepository $teams, DropDownTaskRepository $dropDownTask)
    {
        $this->teams = $teams;
        $this->dropDownTask = $dropDownTask;
    }

    /**
     * 发布测试任务
     * @param $data
     * @throws InvalidParameterException
     */
    public function store($data)
    {
        // 发布人 主负责人
        $promulgatorUser = $mainPrincipalUser = Auth::user();
        $data['promulgator_id'] = $promulgatorUser->id;
        $data['promulgator_name'] = $promulgatorUser->name;
        $data['main_principal_user_id'] = $mainPrincipalUser->id;
        $data['main_principal_user_name'] = $mainPrincipalUser->name;
        // 负责人
        $principalUser = User::find($data['user_id']);
        $data['principal_user_id'] = $principalUser->id;
        $data['principal_user_name'] = $principalUser->name;
        $data['content'] = $data['description'];
        $data['share_address'] = isset($data['share_address']) ? json_encode($data['share_address']) : null;
        $hasSubtasks = request()->has('main_sub_task');
        $data['status'] = $hasSubtasks ? TestTaskStatus::STATUS_NO_BEGIN : TestTaskStatus::STATUS_TO_ASSIGN;
        $task = TestTask::query()->create($data);

        // 添加子任务
        if ($hasSubtasks) {
            $mainSubTaskData = $data['main_sub_task'];
            $handler = User::find($mainSubTaskData['handler_id']);
            $this->addSubTask($task, [
                'handler_id' => $handler->id,
                'handler_name' => $handler->name,
                'is_main' => 1,
                'status' => TestSubTaskStatus::STATUS_NO_BEGIN,
                'expiration_date' => $mainSubTaskData['expiration_date'] ?? null,
                'description' => $mainSubTaskData['description'] ?? '',
            ]);
        } else {
            $this->createEmptyMainSubtask($task);
        }
        if (request()->has('other_sub_tasks')) {
            $otherSubTasks = $data['other_sub_tasks'];
            foreach ($otherSubTasks as $item) {
                $handler = User::find($item['handler_id']);
                $this->addSubTask($task, [
                    'handler_id' => $handler->id,
                    'handler_name' => $handler->name,
                    'is_main' => 0,
                    'status' => TestSubTaskStatus::STATUS_NO_BEGIN,
                    'expiration_date' => $item['expiration_date'] ?? null,
                    'description' => $item['description'] ?? '',
                ]);
            }
        }

        // 关联产品
        if (isset($data['product_id'])) {
            $product = Product::query()->find($data['product_id']);
            if ($product->type != ProductStatus::TypeProduct) {
                throw new InvalidParameterException('产品选择有误！');
            }
            $this->attachProducts($task, $product, request()->input('product_modules', []));
        }

        if (isset($data['media'])) {
            $task->addMedias($data['media']);
        }
    }

    /**
     * 添加子任务
     * @param TestTask $task
     * @param $data
     */
    public function addSubTask(TestTask $task, $data)
    {
        $subTask = $task->subTasks()->create($data);
        event(new TaskSetHandler($subTask, User::query()->find($subTask->handler_id)));
    }

    /**
     * 编辑任务
     * @param TestTask $task
     * @param Request $request
     * @throws InvalidParameterException
     */
    public function updateTask(TestTask $task, Request $request)
    {
        $data = $request->validated();

        // 修改子任务
        if (request()->has('main_sub_task')) {
            $mainSubTaskData = $data['main_sub_task'];
            TestSubTask::query()->where('id', $mainSubTaskData['sub_task_id'])->first()->update($mainSubTaskData);
        }
        if (request()->has('other_sub_tasks')) {
            $otherSubTasks = $data['other_sub_tasks'];
            foreach ($otherSubTasks as $item) {
                TestSubTask::query()->where('id', $item['sub_task_id'])->first()->update($item);
            }
        }

        // 产品附件关联更新
        $product = null;
        if (isset($data['product_id'])) {
            $product = Product::query()->find($data['product_id']);
            if ($product->type != ProductStatus::TypeProduct) {
                throw new InvalidParameterException('产品选择有误！');
            }
        }
        $this->relatedUpdate($task, $product, $request);

        $data['content'] = $data['description'];
        $data['share_address'] = isset($data['share_address']) ? json_encode($data['share_address']) : null;
        $data['source_project_id'] = $data['source_project_id'] ?? 0;
        $task->updated_at = now();
        $task->update($data);
    }

    /**
     * @param TestTask $task
     * @param $data
     * @return bool
     */
    public function update(TestTask $task, $data)
    {
        return $task->update($data);
    }

    /**
     * 更改负责人
     * @param TestTask $task
     * @param $userId
     */
    public function principal(TestTask $task, $userId)
    {
        $principalUser = User::find($userId);
        $data['principal_user_id'] = $principalUser->id;
        $data['principal_user_name'] = $principalUser->name;
        $this->update($task, $data);

        if ($demand = $task->demand()->first()) {
            $demandLik = $demand->demandLinks()->where('type', DemandLinksType::TYPE_TEST)->first();
            // 更新demand_links的测试环节负责人
            $demandLik->update($data);
        }
    }

    /**
     * @param TestTask $task
     * @return array
     */
    public function getPrincipal(TestTask $task)
    {
        // 有搜索
        if (request()->has('user_name')) {
            $userName = request()->input('user_name');
            if (!Str::contains($userName, '%')) {
                $userName = '%' . $userName . '%';
            }
            $result = collect();
            $positions = Position::query()->whereIn('number', ['J0012', 'J0013', 'J0014', 'J0015'])
                ->with(['users' => function ($query) use ($userName) {
                    $query->where('name', 'like', $userName);
                }])->get();
            foreach ($positions as $position) {
                $result = $result->merge($this->filterFields($position->users));
            }
            return $result->unique('id')->sortBy('name')->values()->toArray();
        }

        // 需求测试任务
        if ($demand = $task->demand()->first()) {
            return $this->teams->getTeamPrincipalByProducts($demand, TeamType::TYPE_TEST);
        }

        // 测试内部任务
        // 有产品
        $products = $task->ownProducts()->get();
        if ($products->isNotEmpty()) {
            $product = $products->where('type', ProductStatus::TypeProduct)->first();
            $teams = Team::query()->where('type', TeamType::TYPE_TEST)->where('product_id', $product->id);
            $result = $teams->get()->map(function ($team) {
                return [
                    'id' => $team->user_id,
                    'name' => $team->user_name,
                ];
            });
            return $result->unique('id')->sortBy('name')->values()->toArray();
        }
        // 无产品
        return $this->dropDownTask->testPrincipal();
    }

    protected function filterFields(Collection $usersCollection)
    {
        return $usersCollection->map(function ($user) {
            return ['id' => $user->id, 'name' => $user->name];
        })->toArray();
    }

    /**
     * 创建子任务(添加次要跟进人)
     * @param TestTask $task
     * @param $data
     */
    public function createSubTask(TestTask $task, $data)
    {
        foreach ($data as $item) {
            $principalUser = User::find($item['user_id']);
            $item['handler_id'] = $principalUser->id;
            $item['handler_name'] = $principalUser->name;
            $item['status'] = $this->getDefaultStatus($task);
            $this->addSubTask($task, $item);
        }
        if ($task->status == TestTaskStatus::STATUS_SUBMIT) {
            $task->update(['status' => TestTaskStatus::STATUS_IN_TEST]);
        }
    }

    /**
     * @param TestTask $task
     * @return int
     */
    protected function getDefaultStatus(TestTask $task)
    {
        $demand = $task->demand()->first();
        // 无需求子任务状态默认待测试
        if (empty($demand)) {
            return TestSubTaskStatus::STATUS_NO_BEGIN;
        }
        // 有需求子任务状态：如果需求是待测试、测试中、已完成 => 待测试 ；否则是待发布
        if (in_array($demand->status, [DemandStatus::STATUS_TO_TEST, DemandStatus::STATUS_IN_TEST, DemandStatus::STATUS_COMPLETED])) {
            return TestSubTaskStatus::STATUS_NO_BEGIN;
        }
        return TestSubTaskStatus::STATUS_TO_RELEASE;
    }

    /**
     * 设置处理人
     * @param TestTask $task
     * @param $data
     */
    public function setHandler(TestTask $task, $data)
    {
        $handler = User::find($data['user_id']);
        $data['handler_id'] = $handler->id;
        $data['handler_name'] = $handler->name;
        $data['status'] = $this->getDefaultStatus($task);
        if (request()->has('comment')) {
            $data['description'] = request()->input('comment');
            request()->request->remove('comment');
        }
        $task->update(['expiration_date' => $data['expiration_date']]);
        $mainSubTask = $task->subTasks()->where('is_main', 1)->first();
        if ($mainSubTask) {
            if ($handler->id == $mainSubTask->handler_id) {
                unset($data['status']);
            }
            $mainSubTask->update($data);
            if ($mainSubTask->wasChanged('handler_id')) {
                event(new TaskSetHandler($mainSubTask, $handler));
            }
        } else {
            $data['is_main'] = 1;
            $this->addSubTask($task, $data);
        }
        if ($demand = $task->demand()->first()) {
            $demandLinks = $demand->demandLinks()->where('type', '!=', DemandLinksType::TYPE_TEST)->get();
            if ($demandLinks->isEmpty() && $demand->status == DemandStatus::STATUS_NO_BEGIN) {
                $demand->update([
                    'status' => DemandStatus::STATUS_SUBMIT
                ]);
            }
        }
    }

    /**
     * 修改子任务状态
     * @param TestSubTask $subTask
     * @param int $status
     * @return bool
     */
    public function subTaskStatus(TestSubTask $subTask, int $status)
    {
        return $subTask->update(['status' => $status]);
    }

    /**
     * 开始子任务
     * @param TestSubTask $subTask
     */
    public function subTaskStart(TestSubTask $subTask)
    {
        $subTask->update([
            'status' => TestSubTaskStatus::STATUS_IN_TEST,
            'start_time' => now()->toDateTimeString(),
        ]);
    }

    /**
     * 完成子任务
     * @param TestSubTask $subTask
     * @param array $data
     * @throws InvalidParameterException
     */
    public function subTaskComplete(TestSubTask $subTask, $data)
    {
        if ($data['result'] == 0) {
            $subTask->update(['status' => TestSubTaskStatus::STATUS_IN_TEST]);
        } else {
            // 验收通过
            if (!isset($data['finish_type'])) {
                throw new InvalidParameterException('请选择任务完成情况');
            }
            $subTaskData = [
                'status' => TestSubTaskStatus::STATUS_COMPLETED,
                'finish_time' => now()->toDateTimeString(),
                'finish_type' => $data['finish_type'],
            ];

            $shouldFinishType = $this->shouldFinishType($subTask->expiration_date);
            if ($shouldFinishType != $data['finish_type']) {
                if (!isset($data['difference_reason'])) {
                    throw new InvalidParameterException('请填写差异原因说明');
                } else {
                    $subTaskData['difference_reason'] = $data['difference_reason'];
                }
            }
            $subTask->update($subTaskData);
        }
    }

    /**
     * 暂停子任务
     * @param TestSubTask $subTask
     */
    public function subTaskPause(TestSubTask $subTask)
    {
        $subTask->update([
            'status' => TestSubTaskStatus::STATUS_PAUSED,
            'pause_time' => now(),
        ]);
    }

    /**
     * 提交子任务
     * @param TestSubTask $subTask
     * @param $data
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function subTaskSubmit(TestSubTask $subTask, $data)
    {
        $data['share_address'] = isset($data['share_address']) ? json_encode($data['share_address']) : null;
        $data['status'] = TestSubTaskStatus::STATUS_SUBMIT;
        $data['submit_time'] = now();
        $subTask->update($data);
        // 保存附件
        if (isset($data['media'])) {
            $subTask->addMedias($data['media']);
        }
        event(new TaskSubmit($subTask));
    }

    /**
     * 更新提交
     * @param TestSubTask $subTask
     * @param $data
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function subTaskSubmitUpdate(TestSubTask $subTask, $data)
    {
        $data['share_address'] = isset($data['share_address']) ? json_encode($data['share_address']) : null;
        $subTask->update($data);
        $this->updateMedia($subTask, $data);
    }

    /**
     * 撤销提交子任务
     * @param TestSubTask $subTask
     */
    public function subTaskSubmitCancel(TestSubTask $subTask)
    {
        $subTask->update([
            'status' => TestSubTaskStatus::STATUS_IN_TEST,
        ]);
    }

    /**
     * 更改任务预计交付日期
     * @param TestTask $task
     * @param $expirationDate
     */
    public function expirationDate(TestTask $task, $expirationDate)
    {
        $task->update(['expiration_date' => $expirationDate]);
        $mainSubTask = $task->subTasks()->where('is_main', 1)->first();
        if ($mainSubTask) {
            $mainSubTask->update(['expiration_date' => $expirationDate]);
        }
    }

    /**
     * @param TestSubTask $subTask
     */
    public function subTaskRevocation(TestSubTask $subTask)
    {
        $this->subTaskStatus($subTask, TestSubTaskStatus::STATUS_REVOCATION);
        $subTask->clearMedias();
    }

    /**
     * @param TestTask $task
     * @param $data
     */
    public function verify(TestTask $task, $data)
    {
        $principal = User::query()->find($data['user_id']);
        $data['principal_user_id'] = $principal->id;
        $data['principal_user_name'] = $principal->name;
        $data['status'] = TestTaskStatus::STATUS_CLOSED;
        if ($demand = $task->demand()->first()) {
            $designTask = $demand->designTasks()->whereNotIn('status', [DesignTaskStatus::STATUS_COMPLETED, DesignTaskStatus::STATUS_REVOCATION])->get();
            $devTask = $demand->devTasks()->whereNotIn('status', [DevTaskStatus::STATUS_COMPLETED, DevTaskStatus::STATUS_REVOCATION])->get();
            if ($designTask->isEmpty() && $devTask->isEmpty()) {
                $data['status'] = TestTaskStatus::STATUS_TO_ASSIGN;
            }
            // 更新demand_links的测试环节负责人
            $demandLik = $demand->demandLinks()->where('type', DemandLinksType::TYPE_TEST)->first();
            $demandLik->update([
                'principal_user_id' => $principal->id,
                'principal_user_name' => $principal->name,
            ]);
        }
        $task->update($data);
        $this->createEmptyMainSubtask($task);
    }

    /**
     * 添加空主子任务
     * @param TestTask $task
     */
    protected function createEmptyMainSubtask($task)
    {
        $task->subTasks()->create([
            'is_main' => 1,
            'status' => TestSubTaskStatus::STATUS_CLOSED,
        ]);
    }

    /**
     * @param TestTask $task
     * @param $data
     */
    public function verifyUpdate(TestTask $task, $data)
    {
        $principal = User::query()->find($data['user_id']);
        $data['principal_user_id'] = $principal->id;
        $data['principal_user_name'] = $principal->name;
        if ($demand = $task->demand()->first()) {
            // 更新demand_links的测试环节负责人
            $demandLik = $demand->demandLinks()->where('type', DemandLinksType::TYPE_TEST)->first();
            $demandLik->update([
                'principal_user_id' => $principal->id,
                'principal_user_name' => $principal->name,
            ]);
        }
        $task->update($data);
        $subTasks = $task->subTasks()->get();
        if ($subTasks->isEmpty()) {
            $this->createEmptyMainSubtask($task);
        }
    }

    /**
     * @param TestTask $task
     * @return TestTask
     */
    public function details(TestTask $task)
    {
        $testTask = $task->load(['ownProducts', 'subTasks', 'subTasks.media', 'media', 'demand', 'demand.products', 'project',
            'demand.versions', 'demand.designSubtasks.version', 'demand.devSubtasks.version'])
            ->append(['product_category', 'policies',]);
        // 预计纳入版本
        $testTask->expected_versions = [];
        // 压测
        $testTask->stress_test = 0;
        // 任务纳入版本
        $taskVersions = [];
        if ($testTask->demand_id) {
            $testTask->expected_versions = $testTask->demand->versions;
            unset($testTask->demand->versions);
            $subTasks = $testTask->demand->designSubtasks->merge($testTask->demand->devSubtasks);
            foreach ($subTasks as $subTask) {
                if ($releaseVersion = $subTask->version) {
                    if ($subTask->stress_test == 1) {
                        $testTask->stress_test = 1;
                    }
                    if ($subTask->release_type === 0 && !empty($subTask->version)) {
                        $version = $subTask->version->toArray();
                        $version['release_type'] = $subTask->release_type;
                        $taskVersions[] = $version;
                    } elseif (in_array($subTask->release_type, [1, 2])) {
                        $version['release_type'] = $subTask->release_type;
                        $taskVersions[] = $version;
                    }
                }
            }
            unset($testTask->demand->designSubtasks);
            unset($testTask->demand->devSubtasks);
        }
        $testTask->task_versions = collect($taskVersions)->unique('id')->toArray();
        $testTask->main_subtask = $testTask->subTasks->where('is_main', 1)->first();
        $testTask->other_subtasks = $testTask->subTasks->where('is_main', 0)->values();
        unset($testTask->subTasks);
        return $testTask;
    }
}
