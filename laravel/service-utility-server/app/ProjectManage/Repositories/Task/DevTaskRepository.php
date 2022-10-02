<?php

namespace App\ProjectManage\Repositories\Task;

use App\Enums\ProjectManage\DemandLinksType;
use App\Enums\ProjectManage\DesignSubTaskStatus;
use App\Enums\ProjectManage\DesignTaskStatus;
use App\Enums\ProjectManage\DevSubTaskStatus;
use App\Enums\ProjectManage\DevTaskStatus;
use App\Enums\ProjectManage\ProductStatus;
use App\Enums\ProjectManage\Releases\SubTaskReleaseStatus;
use App\Enums\ProjectManage\Releases\SubTaskReleaseType;
use App\Enums\ProjectManage\TeamType;
use App\Events\PM\Task\TaskSetHandler;
use App\Events\PM\Task\TaskSubmit;
use App\Exceptions\System\InvalidParameterException;
use App\Models\User;
use App\ProjectManage\Models\DevSubTask;
use App\ProjectManage\Models\DevTask;
use App\ProjectManage\Models\Product;
use App\ProjectManage\Models\Team;
use App\ProjectManage\Repositories\DropDownTaskRepository;
use App\ProjectManage\Repositories\TeamRepository;
use App\Traits\Task\TaskFinishTrait;
use App\Traits\Task\TaskMediaTrait;
use App\Traits\Task\TaskRepositoryTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevTaskRepository
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
     * 发布任务
     * @param $data
     * @throws InvalidParameterException
     */
    public function store($data)
    {
        // 发布人、主负责人
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
        $data['status'] = $hasSubtasks ? DevTaskStatus::STATUS_NO_BEGIN : DevTaskStatus::STATUS_TO_ASSIGN;
        $devTask = DevTask::query()->create($data);

        // 添加子任务
        if ($hasSubtasks) {
            $mainSubTaskData = $data['main_sub_task'];
            $handler = User::find($mainSubTaskData['handler_id']);
            $subTaskData = [
                'handler_id' => $handler->id,
                'handler_name' => $handler->name,
                'is_main' => 1,
                'status' => DevSubTaskStatus::STATUS_NO_BEGIN,
                'expiration_date' => $mainSubTaskData['expiration_date'] ?? null,
                'description' => $mainSubTaskData['description'] ?? '',
                'adjust_reason' => $mainSubTaskData['adjust_reason'] ?? '',
            ];
            // 考核相关
            $appraisalData = $this->subTaskAppraisalData($mainSubTaskData['standard_workload']);
            $this->addSubTask($devTask, array_merge($subTaskData, $appraisalData));
        } else {
            $this->createEmptyMainSubtask($devTask);
        }
        if (request()->has('other_sub_tasks')) {
            $otherSubTasks = $data['other_sub_tasks'];
            foreach ($otherSubTasks as $item) {
                $handler = User::find($item['handler_id']);
                $subTaskData = [
                    'handler_id' => $handler->id,
                    'handler_name' => $handler->name,
                    'is_main' => 0,
                    'status' => DevSubTaskStatus::STATUS_NO_BEGIN,
                    'expiration_date' => $item['expiration_date'] ?? null,
                    'description' => $item['description'] ?? '',
                    'adjust_reason' => $item['adjust_reason'] ?? '',
                ];
                // 考核相关
                $appraisalData = $this->subTaskAppraisalData($item['standard_workload']);
                $this->addSubTask($devTask, array_merge($subTaskData, $appraisalData));
            }
        }

        // 关联产品
        if (isset($data['product_id'])) {
            $product = Product::query()->find($data['product_id']);
            if ($product->type != ProductStatus::TypeProduct) {
                throw new InvalidParameterException('产品选择有误！');
            }
            $this->attachProducts($devTask, $product, request()->input('product_modules', []));
        }

        // 处理附件
        if (isset($data['media'])) {
            $devTask->addMedias($data['media']);
        }

        // 纳入版本
        if (isset($data['release_version_ids'])) {
            $devTask->versions()->attach($data['release_version_ids']);
        }
    }

    /**
     * 任务考核数据
     * @param $workload
     * @return array
     * @throws InvalidParameterException
     */
    public function subTaskAppraisalData($workload)
    {
        [$performanceLevel, $standardFactor] = DevSubTask::getPerformanceLevelAndFactor($workload);
        return [
            'standard_workload' => $workload,
            'standard_factor' => $standardFactor,
            'performance_level' => $performanceLevel,
        ];
    }

    /**
     * 添加子任务
     * @param DevTask $task
     * @param $data
     */
    public function addSubTask(DevTask $task, $data)
    {
        $subTask = $task->subTasks()->create($data);
        event(new TaskSetHandler($subTask, User::query()->find($subTask->handler_id)));
    }

    /**
     * 编辑内部任务
     * @param DevTask $task
     * @param Request $request
     * @throws InvalidParameterException
     */
    public function updateTask(DevTask $task, Request $request)
    {
        $data = $request->validated();

        // 修改子任务
        if (request()->has('main_sub_task')) {
            $mainSubTaskData = $data['main_sub_task'];
            $mainSubTask = DevSubTask::query()->where('id', $mainSubTaskData['sub_task_id'])->first();
            $appraisalData = $this->subTaskAppraisalData($mainSubTaskData['standard_workload']);
            $mainSubTask->update(array_merge($mainSubTaskData, $appraisalData));
        }
        if (request()->has('other_sub_tasks')) {
            $otherSubTasks = $data['other_sub_tasks'];
            foreach ($otherSubTasks as $item) {
                $otherSubTask = DevSubTask::query()->where('id', $item['sub_task_id'])->first();
                $appraisalData = $this->subTaskAppraisalData($item['standard_workload']);
                $otherSubTask->update(array_merge($item, $appraisalData));
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

        // 纳入版本修改
        if (isset($data['release_version_ids'])) {
            $task->versions()->sync($data['release_version_ids']);
        } else {
            $task->versions()->detach();
        }
    }

    /**
     * @param DevTask $task
     * @param $data
     * @return bool
     */
    public function update(DevTask $task, $data)
    {
        return $task->update($data);
    }

    /**
     * 更改任务负责人
     * @param DevTask $task
     * @param $request
     */
    public function principal(DevTask $task, $request)
    {
        $user = User::find($request->user_id);
        $data['principal_user_id'] = $user->id;
        $data['principal_user_name'] = $user->name;
        $this->update($task, $data);

        if ($demand = $task->demand()->first()) {
            $demand->update(['level' => $request->level]);
            $demandLik = $demand->demandLinks()->where('type', DemandLinksType::TYPE_DEVELOP)->first();
            // 更新demand_links的开发环节负责人
            $demandLik->update($data);
        }
    }

    /**
     * @param DevTask $task
     * @return array
     */
    public function getPrincipal(DevTask $task)
    {
        $teams = Team::query()->where('type', TeamType::TYPE_DEVELOP);
        // 有搜索条件
        if (request()->has('user_name')) {
            $teams->search('user_name', request()->input('user_name'));
            $result = $teams->get()->map(function ($team) {
                return [
                    'id' => $team->user_id,
                    'name' => $team->user_name,
                ];
            });
            return $result->unique('id')->sortBy('name')->values()->toArray();
        }

        // 需求开发任务
        if ($demand = $task->demand()->first()) {
            return $this->teams->getTeamPrincipalByProducts($demand, TeamType::TYPE_DEVELOP);
        }

        // 开发内部任务
        // 有产品
        $products = $task->ownProducts()->get();
        if ($products->isNotEmpty()) {
            $product = $products->where('type', ProductStatus::TypeProduct)->first();
            $teams->where('product_id', $product->id);
            $result = $teams->get()->map(function ($team) {
                return [
                    'id' => $team->user_id,
                    'name' => $team->user_name,
                ];
            });
            return $result->unique('id')->sortBy('name')->values()->toArray();
        }
        // 无产品
        return $this->dropDownTask->devPrincipal();
    }

    /**
     * 创建子任务(添加次要跟进人)
     * @param DevTask $task
     * @param $data
     */
    public function createSubTask(DevTask $task, $data)
    {
        foreach ($data as $item) {
            $item['handler_id'] = $item['user_id'];
            $item['handler_name'] = User::find($item['user_id'])->name;
            $item['status'] = DevSubTaskStatus::STATUS_NO_BEGIN;
            $appraisalData = $this->subTaskAppraisalData($item['standard_workload']);
            $this->addSubTask($task, array_merge($item, $appraisalData));
        }
        if ($task->status == DevTaskStatus::STATUS_SUBMIT) {
            $task->update(['status' => DevTaskStatus::STATUS_IN_PROGRESS]);
        }
    }

    /**
     * 设置任务处理人(主要跟进人)
     * @param DevTask $task
     * @param $data
     */
    public function setHandler(DevTask $task, $data)
    {
        $handler = User::find($data['user_id']);
        $data['handler_id'] = $handler->id;
        $data['handler_name'] = $handler->name;
        if (request()->has('comment')) {
            $data['description'] = request()->input('comment');
            request()->request->remove('comment');
        }
        $data['status'] = DevSubTaskStatus::STATUS_NO_BEGIN;
        $task->update(['expiration_date' => $data['expiration_date']]);
        $mainSubTask = $task->subTasks()->where('is_main', 1)->first();
        // 考核数据
        $appraisalData = $this->subTaskAppraisalData($data['standard_workload']);
        $data = array_merge($data, $appraisalData);
        if ($mainSubTask) {
            // 跟进人没有变化，不改变状态
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
    }

    /**
     * 修改子任务状态
     * @param DevSubTask $subTask
     * @param $status
     * @return bool
     */
    public function subTaskStatus(DevSubTask $subTask, $status)
    {
        return $subTask->update(['status' => $status]);
    }

    /**
     * 开始子任务
     * @param DevSubTask $subTask
     */
    public function subTaskStart(DevSubTask $subTask)
    {
        $subTask->update([
            'status' => DevSubTaskStatus::STATUS_IN_PROGRESS,
            'start_time' => now()->toDateTimeString(),
        ]);
    }

    /**
     * 完成子任务
     * @param DevSubTask $subTask
     * @param array $data
     * @throws InvalidParameterException
     */
    public function subTaskComplete(DevSubTask $subTask, $data)
    {
        if ($data['result'] == 0) {
            $subTask->update(['status' => DevSubTaskStatus::STATUS_IN_PROGRESS]);
        } else {
            // 验收通过
            if (!isset($data['finish_type'])) {
                throw new InvalidParameterException('请选择任务完成情况');
            }
            $subTaskData = [
                'status' => DevSubTaskStatus::STATUS_COMPLETED,
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
            // 计算考核偏移系数
            // 按时完成
            if ($data['finish_type'] == DesignSubTaskStatus::FINISH_TYPE_ON_TIME) {
                $offsetDays = 0;
            } else {
                // 存在差异
                $offsetDays = $this->getDiffDays(now(), $subTask->expiration_date);
            }
            $offsetFactor = DevSubTask::getOffsetFactor($offsetDays);
            $subTaskData['offset_days'] = $offsetDays;
            $subTaskData['offset_factor'] = $offsetFactor;
            $subTask->update($subTaskData);
        }
    }

    /**
     * 提交子任务
     * @param DevSubTask $subTask
     * @param $data
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function subTaskSubmit(DevSubTask $subTask, $data)
    {
        $data['share_address'] = isset($data['share_address']) ? json_encode($data['share_address']) : null;
        $data['status'] = DevSubTaskStatus::STATUS_SUBMIT;
        $data['submit_time'] = now();
        $data['branch_name'] = $data['branch_name'] ?? '';
        $data['release_version_id'] = $data['release_version_id'] ?? null;
        $data['release_comment'] = $data['release_comment'] ?? '';
        $data['product_confirmed'] = isset($data['release_version_id']) ? 0 : null;
        $data['release_status'] = isset($data['release_version_id']) ? SubTaskReleaseStatus::NO_RELEASE_TEST : null;
        $subTask->update($data);
        // 保存附件
        if (isset($data['media'])) {
            $subTask->addMedias($data['media']);
        }
        event(new TaskSubmit($subTask));

        if ($subTask->release_version_id) {
            $this->submitOrUpdateVersion($subTask);
        }
    }

    /**
     * @param DevSubTask $subTask
     * @param $data
     * @throws InvalidParameterException
     */
    public function subTaskSubmitUpdate(DevSubTask $subTask, $data)
    {
        $data['share_address'] = isset($data['share_address']) ? json_encode($data['share_address']) : null;
        $subTask->update($data);
        $this->updateMedia($subTask, $data);
        // 更新提交日志备注
        if (isset($data['comment'])) {
            $lastSubmitLog = $subTask->statusLogs()->where('new_status', DevSubTaskStatus::STATUS_SUBMIT)->orderBy('id', 'desc')->first();
            $lastSubmitLog->update(['comment' => $data['comment']]);
        }
    }

    /**
     * 撤销提交子任务
     * @param DevSubTask $subTask
     */
    public function subTaskSubmitCancel(DevSubTask $subTask)
    {
        $subTask->update([
            'status' => DevSubTaskStatus::STATUS_IN_PROGRESS,
            'release_type' => null,
            'branch_name' => '',
            'has_sql' => null,
            'release_version_id' => null,
            'stress_test' => null,
            'release_comment' => '',
            'release_status' => null,
        ]);
    }

    /**
     * 暂停子任务
     * @param DevSubTask $subTask
     */
    public function subTaskPause(DevSubTask $subTask)
    {
        $subTask->update([
            'status' => DevSubTaskStatus::STATUS_PAUSED,
            'pause_time' => now(),
        ]);
    }

    /**
     * 更改任务预计交付日期
     * @param DevTask $task
     * @param $expirationDate
     */
    public function expirationDate(DevTask $task, $data)
    {
        $task->update(['expiration_date' => $data['expiration_date']]);
        $mainSubTask = $task->subTasks()->where('is_main', 1)->first();
        if ($mainSubTask) {
            $appraisalData = $this->subTaskAppraisalData($data['standard_workload']);
            $mainSubTask->update(array_merge($data, $appraisalData));
        }
    }

    /**
     * 撤销子任务
     * @param DevSubTask $subTask
     */
    public function subTaskRevocation(DevSubTask $subTask)
    {
        $this->subTaskStatus($subTask, DevSubTaskStatus::STATUS_REVOCATION);
        $subTask->clearMedias();
    }

    /**
     * @param DevTask $task
     * @param $data
     */
    public function verify(DevTask $task, $data)
    {
        $principal = User::query()->find($data['user_id']);
        $data['principal_user_id'] = $principal->id;
        $data['principal_user_name'] = $principal->name;
        $data['status'] = DevTaskStatus::STATUS_CLOSED;
        if ($demand = $task->demand()->first()) {
            $designTask = $demand->designTasks()->whereNotIn('status', [DesignTaskStatus::STATUS_COMPLETED, DesignTaskStatus::STATUS_REVOCATION])->get();
            if ($designTask->isEmpty()) {
                $data['status'] = DevTaskStatus::STATUS_TO_ASSIGN;
            }
            // 更新demand_links的开发环节负责人
            $demandLik = $demand->demandLinks()->where('type', DemandLinksType::TYPE_DEVELOP)->first();
            $demandLik->update([
                'principal_user_id' => $principal->id,
                'principal_user_name' => $principal->name,
            ]);
        }
        $task->update($data);
        $this->createEmptyMainSubtask($task);
    }

    /**
     * 生成空主子任务
     * @param $task
     */
    protected function createEmptyMainSubtask($task)
    {
        $task->subTasks()->create([
            'is_main' => 1,
            'status' => DevSubTaskStatus::STATUS_CLOSED,
        ]);
    }

    /**
     * @param DevTask $task
     * @param $data
     */
    public function verifyUpdate(DevTask $task, $data)
    {
        $principal = User::query()->find($data['user_id']);
        $data['principal_user_id'] = $principal->id;
        $data['principal_user_name'] = $principal->name;

        if ($demand = $task->demand()->first()) {
            // 更新demand_links的开发环节负责人
            $demandLik = $demand->demandLinks()->where('type', DemandLinksType::TYPE_DEVELOP)->first();
            $demandLik->update([
                'principal_user_id' => $principal->id,
                'principal_user_name' => $principal->name,
            ]);
        }
        $task->update($data);
    }

    /**
     * @param DevTask $task
     * @return DevTask
     */
    public function details(DevTask $task)
    {
        $devTask = $task->load(['ownProducts', 'versions', 'subTasks.version', 'subTasks.media', 'media', 'demand', 'project', 'demand.products', 'demand.versions',])
            ->append(['product_category', 'policies',]);
        // 预计纳入版本
        $devTask->expected_versions = [];
        if ($devTask->demand_id) {
            $devTask->expected_versions = $devTask->demand->versions;
            unset($devTask->demand->versions);
        } else {
            $devTask->expected_versions = $devTask->versions;
        }
        unset($devTask->versions);
        $devTask->stress_test = 0;
        $taskVersions = [];
        $subTasks = collect();
        foreach ($devTask->subTasks as $subTask) {
            $subTask->task = $devTask;
            $subTask->hasDemand = $devTask->demand;
            $subTask->append(['policies']);
            if ($releaseVersion = $subTask->version) {
                if ($subTask->stress_test == 1) {
                    $devTask->stress_test = 1;
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
            $subTaskArr = $subTask->toArray();
            unset($subTaskArr['version']);
            unset($subTaskArr['task']);
            unset($subTaskArr['hasDemand']);
            $subTasks = $subTasks->merge([$subTaskArr]);
        }
        $devTask->task_versions = $taskVersions;
        $devTask->main_subtask = $subTasks->where('is_main', 1)->first();
        $devTask->other_subtasks = $subTasks->where('is_main', 0)->values();
        unset($devTask->subTasks);
        return $devTask;
    }

    /**
     * @param DevSubTask $subTask
     * @param $data
     */
    public function subTaskUpdateVersion(DevSubTask $subTask, $data)
    {
        if ($data['release_type'] == SubTaskReleaseType::FOLLOW_VERSION) {
            $data['branch_name'] = $data['branch_name'] ?? '';
            $data['release_version_id'] = $data['release_version_id'] ?? null;
            if ($subTask->release_version_id != $data['release_version_id']) {
                $data['product_confirmed'] = 0;
                $data['release_status'] = SubTaskReleaseStatus::NO_RELEASE_TEST;
            }
            $data['has_sql'] = $data['has_sql'] ?? null;
            $data['stress_test'] = $data['stress_test'] ?? null;
        } else {
            $data['branch_name'] = '';
            $data['release_version_id'] = null;
            $data['product_confirmed'] = null;
            $data['has_sql'] = null;
            $data['stress_test'] = null;
            $data['release_status'] = null;
        }
        $data['release_comment'] = $data['release_comment'] ?? '';
        $subTask->update($data);

        // 修改了版本号
        if ($subTask->wasChanged('release_version_id') && $subTask->release_version_id) {
            $this->submitOrUpdateVersion($subTask);
        }
    }

    /**
     * @param Request $request
     * @return array
     * @throws InvalidParameterException
     */
    public function getWorkload(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-d'));
        $expirationDate = $request->input('expiration_date');
        $workload = getWorkDays($startDate, $expirationDate);
        [$performanceLevel, $standardFactor] = DevSubTask::getPerformanceLevelAndFactor($workload);
        return [
            'standard_workload' => $workload,
            'standard_factor' => $standardFactor,
            'performance_level' => $performanceLevel,
        ];
    }

    /**
     * @param DevSubTask $subTask
     * @param array $data
     * @throws InvalidParameterException
     */
    public function subTaskExpirationDate(DevSubTask $subTask, array $data)
    {
        $appraisalData = $this->subTaskAppraisalData($data['standard_workload']);
        $subTask->update(array_merge($data, $appraisalData));
        if ($subTask->is_main == 1) {
            $subTask->task()->first()->update(['expiration_date' => $data['expiration_date']]);
        }
    }
}
