<?php

namespace App\ProjectManage\Repositories\Task;

use App\Enums\ProjectManage\DemandLinksType;
use App\Enums\ProjectManage\DesignSubTaskStatus;
use App\Enums\ProjectManage\ProductStatus;
use App\Enums\ProjectManage\Releases\SubTaskReleaseStatus;
use App\Enums\ProjectManage\Releases\SubTaskReleaseType;
use App\Enums\ProjectManage\Task\MobileSubTaskStatus;
use App\Enums\ProjectManage\Task\MobileTaskStatus;
use App\Enums\ProjectManage\TeamType;
use App\Events\PM\Task\TaskSetHandler;
use App\Events\PM\Task\TaskSubmit;
use App\Exceptions\System\InvalidParameterException;
use App\Models\User;
use App\ProjectManage\Models\MobileSubTask;
use App\ProjectManage\Models\MobileTask;
use App\ProjectManage\Models\Product;
use App\ProjectManage\Models\Team;
use App\ProjectManage\Repositories\DropDownTaskRepository;
use App\ProjectManage\Repositories\TeamRepository;
use App\Traits\Task\TaskFinishTrait;
use App\Traits\Task\TaskMediaTrait;
use App\Traits\Task\TaskRepositoryTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MobileTaskRepository
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
     * 发布前端任务
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
        $principalUser = User::query()->find($data['user_id']);
        $data['principal_user_id'] = $principalUser->id;
        $data['principal_user_name'] = $principalUser->name;
        $data['content'] = $data['description'];
        $data['share_address'] = isset($data['share_address']) ? json_encode($data['share_address']) : null;
        $hasSubtasks = request()->has('main_sub_task');
        $data['status'] = $hasSubtasks ? MobileTaskStatus::STATUS_NO_BEGIN : MobileTaskStatus::STATUS_TO_ASSIGN;
        $mobileTask = MobileTask::query()->create($data);

        // 添加子任务
        if ($hasSubtasks) {
            $mainSubTaskData = $data['main_sub_task'];
            $handler = User::query()->find($mainSubTaskData['handler_id']);
            $subTaskData = [
                'handler_id' => $handler->id,
                'handler_name' => $handler->name,
                'is_main' => 1,
                'status' => MobileSubTaskStatus::STATUS_NO_BEGIN,
                'expiration_date' => $mainSubTaskData['expiration_date'] ?? null,
                'description' => $mainSubTaskData['description'] ?? '',
                'adjust_reason' => $mainSubTaskData['adjust_reason'] ?? '',
            ];
            // 考核相关
            $appraisalData = $this->subTaskAppraisalData($mainSubTaskData['standard_workload']);
            $this->addSubTask($mobileTask, array_merge($subTaskData, $appraisalData));
        } else {
            $this->createEmptyMainSubtask($mobileTask);
        }
        if (request()->has('other_sub_tasks')) {
            $otherSubTasks = $data['other_sub_tasks'];
            foreach ($otherSubTasks as $item) {
                $handler = User::query()->find($item['handler_id']);
                $subTaskData = [
                    'handler_id' => $handler->id,
                    'handler_name' => $handler->name,
                    'is_main' => 0,
                    'status' => MobileSubTaskStatus::STATUS_NO_BEGIN,
                    'expiration_date' => $item['expiration_date'] ?? null,
                    'description' => $item['description'] ?? '',
                    'adjust_reason' => $item['adjust_reason'] ?? '',
                ];
                // 考核相关
                $appraisalData = $this->subTaskAppraisalData($item['standard_workload']);
                $this->addSubTask($mobileTask, array_merge($subTaskData, $appraisalData));
            }
        }

        // 关联产品
        if (isset($data['product_id'])) {
            $product = Product::query()->find($data['product_id']);
            if ($product->type != ProductStatus::TypeProduct) {
                throw new InvalidParameterException('产品选择有误！');
            }
            $this->attachProducts($mobileTask, $product, request()->input('product_modules', []));
        }

        // 处理附件
        if (isset($data['media'])) {
            $mobileTask->addMedias($data['media']);
        }

        // 纳入版本
        if (isset($data['release_version_ids'])) {
            $mobileTask->versions()->attach($data['release_version_ids']);
        }
    }

    /**
     * 生成空主子任务
     * @param $task
     */
    protected function createEmptyMainSubtask($task)
    {
        $task->subTasks()->create([
            'is_main' => 1,
            'status' => MobileSubTaskStatus::STATUS_CLOSED,
        ]);
    }

    /**
     * 添加子任务
     * @param $task
     * @param $data
     */
    public function addSubTask($task, $data)
    {
        $subTask = $task->subTasks()->create($data);
        event(new TaskSetHandler($subTask, User::query()->find($subTask->handler_id)));
    }

    /**
     * @param MobileTask $task
     * @param Request $request
     * @throws InvalidParameterException
     */
    public function updateTask(MobileTask $task, Request $request)
    {
        $data = $request->validated();

        // 修改子任务
        if (request()->has('main_sub_task')) {
            $mainSubTaskData = $data['main_sub_task'];
            $mainSubTask = MobileSubTask::query()->where('id', $mainSubTaskData['sub_task_id'])->first();
            $appraisalData = $this->subTaskAppraisalData($mainSubTaskData['standard_workload']);
            $mainSubTask->update(array_merge($mainSubTaskData, $appraisalData));
        }
        if (request()->has('other_sub_tasks')) {
            $otherSubTasks = $data['other_sub_tasks'];
            foreach ($otherSubTasks as $item) {
                $otherSubTask = MobileSubTask::query()->where('id', $item['sub_task_id'])->first();
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
     * @param MobileTask $task
     * @param array $data
     * @return bool
     */
    public function update(MobileTask $task, array $data)
    {
        return $task->update($data);
    }

    /**
     * @param MobileTask $task
     * @return array
     */
    public function getPrincipal(MobileTask $task)
    {
        $teams = Team::query()->where('type', TeamType::TYPE_MOBILE);
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
            return $this->teams->getTeamPrincipalByProducts($demand, TeamType::TYPE_MOBILE);
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
        return $this->dropDownTask->mobilePrincipal();
    }

    /**
     * @param MobileTask $task
     * @param array $data
     * @throws InvalidParameterException
     */
    public function expirationDate(MobileTask $task, array $data)
    {
        $task->update(['expiration_date' => $data['expiration_date']]);
        $mainSubTask = $task->subTasks()->where('is_main', 1)->first();
        if ($mainSubTask) {
            $appraisalData = $this->subTaskAppraisalData($data['standard_workload']);
            $mainSubTask->update(array_merge($data, $appraisalData));
        }
    }

    /**
     * @param MobileTask $task
     * @param array $data
     */
    public function verify(MobileTask $task, array $data)
    {
        $principal = User::query()->find($data['user_id']);
        $data['principal_user_id'] = $principal->id;
        $data['principal_user_name'] = $principal->name;
        $data['status'] = MobileTaskStatus::STATUS_CLOSED;
        if ($demand = $task->demand()->first()) {
            $designTask = $demand->designTasks()->whereNotIn('status', [MobileTaskStatus::STATUS_COMPLETED, MobileTaskStatus::STATUS_REVOCATION])->get();
            if ($designTask->isEmpty()) {
                $data['status'] = MobileTaskStatus::STATUS_TO_ASSIGN;
            }
            // 更新demand_links的开发环节负责人
            $demandLik = $demand->demandLinks()->where('type', DemandLinksType::TYPE_MOBILE)->first();
            $demandLik->update([
                'principal_user_id' => $principal->id,
                'principal_user_name' => $principal->name,
            ]);
        }
        $task->update($data);
        $this->createEmptyMainSubtask($task);
    }

    /**
     * @param MobileTask $task
     * @param array $data
     */
    public function verifyUpdate(MobileTask $task, array $data)
    {
        $principal = User::query()->find($data['user_id']);
        $data['principal_user_id'] = $principal->id;
        $data['principal_user_name'] = $principal->name;

        if ($demand = $task->demand()->first()) {
            // 更新demand_links的开发环节负责人
            $demandLik = $demand->demandLinks()->where('type', DemandLinksType::TYPE_MOBILE)->first();
            $demandLik->update([
                'principal_user_id' => $principal->id,
                'principal_user_name' => $principal->name,
            ]);
        }
        $task->update($data);
    }

    /**
     * @param MobileTask $task
     * @return MobileTask
     */
    public function details(MobileTask $task)
    {
        $task = $task->load(['ownProducts', 'versions', 'subTasks.version', 'subTasks.media', 'media', 'demand', 'project', 'demand.products', 'demand.versions',])
            ->append(['product_category', 'policies',]);
        // 预计纳入版本
        $task->expected_versions = [];
        if ($task->demand_id) {
            $task->expected_versions = $task->demand->versions;
            unset($task->demand->versions);
        } else {
            $task->expected_versions = $task->versions;
        }
        unset($task->versions);
        $task->stress_test = 0;
        $taskVersions = [];
        $subTasks = collect();
        foreach ($task->subTasks as $subTask) {
            $subTask->task = $task;
            $subTask->hasDemand = $task->demand;
            $subTask->append(['policies']);
            if ($releaseVersion = $subTask->version) {
                if ($subTask->stress_test == 1) {
                    $task->stress_test = 1;
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
        $task->task_versions = $taskVersions;
        $task->main_subtask = $subTasks->where('is_main', 1)->first();
        $task->other_subtasks = $subTasks->where('is_main', 0)->values();
        unset($task->subTasks);
        return $task;
    }

    /**
     * @param MobileTask $task
     * @param $data
     */
    public function createSubTask(MobileTask $task, $data)
    {
        DB::transaction(function () use ($task, $data) {
            foreach ($data as $item) {
                $item['handler_id'] = $item['user_id'];
                $item['handler_name'] = User::find($item['user_id'])->name;
                $item['status'] = MobileSubTaskStatus::STATUS_NO_BEGIN;
                $appraisalData = $this->subTaskAppraisalData($item['standard_workload']);
                $this->addSubTask($task, array_merge($item, $appraisalData));
            }
            if ($task->status == MobileTaskStatus::STATUS_SUBMIT) {
                $task->update(['status' => MobileTaskStatus::STATUS_IN_PROGRESS]);
            }
        });
    }

    /**
     * @param MobileTask $task
     * @param array $data
     * @throws InvalidParameterException
     */
    public function setHandler(MobileTask $task, array $data)
    {
        $handler = User::query()->find($data['user_id']);
        $data['handler_id'] = $handler->id;
        $data['handler_name'] = $handler->name;
        if (request()->has('comment')) {
            $data['description'] = request()->input('comment');
            request()->request->remove('comment');
        }
        $data['status'] = MobileSubTaskStatus::STATUS_NO_BEGIN;
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
     * @param MobileSubTask $subTask
     */
    public function subTaskStart(MobileSubTask $subTask)
    {
        $subTask->update([
            'status' => MobileSubTaskStatus::STATUS_IN_PROGRESS,
            'start_time' => now()->toDateTimeString(),
        ]);
    }

    /**
     * @param MobileSubTask $subTask
     * @param array $data
     * @throws InvalidParameterException
     */
    public function subTaskSubmit(MobileSubTask $subTask, array $data)
    {
        $data['share_address'] = isset($data['share_address']) ? json_encode($data['share_address']) : null;
        $data['status'] = MobileSubTaskStatus::STATUS_SUBMIT;
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
     * @param MobileSubTask $subTask
     * @param array $data
     */
    public function subTaskSubmitUpdate(MobileSubTask $subTask, array $data)
    {
        $data['share_address'] = isset($data['share_address']) ? json_encode($data['share_address']) : null;
        $subTask->update($data);
        $this->updateMedia($subTask, $data);
        // 更新提交日志备注
        if (isset($data['comment'])) {
            $lastSubmitLog = $subTask->statusLogs()->where('new_status', MobileSubTaskStatus::STATUS_SUBMIT)->orderBy('id', 'desc')->first();
            $lastSubmitLog->update(['comment' => $data['comment']]);
        }
    }

    /**
     * @param MobileSubTask $subTask
     */
    public function subTaskSubmitCancel(MobileSubTask $subTask)
    {
        $subTask->update([
            'status' => MobileSubTaskStatus::STATUS_IN_PROGRESS,
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
     * @param MobileSubTask $subTask
     */
    public function subTaskRevocation(MobileSubTask $subTask)
    {
        $this->subTaskStatus($subTask, MobileSubTaskStatus::STATUS_REVOCATION);
        $subTask->clearMedias();
    }

    /**
     * @param MobileSubTask $subTask
     * @param $status
     * @return bool
     */
    public function subTaskStatus(MobileSubTask $subTask, $status)
    {
        return $subTask->update(['status' => $status]);
    }

    /**
     * @param MobileSubTask $subTask
     */
    public function subTaskPause(MobileSubTask $subTask)
    {
        $subTask->update([
            'status' => MobileSubTaskStatus::STATUS_PAUSED,
            'pause_time' => now(),
        ]);
    }

    /**
     * @param MobileSubTask $subTask
     * @param array $data
     * @throws InvalidParameterException
     */
    public function subTaskComplete(MobileSubTask $subTask, array $data)
    {
        if ($data['result'] == 0) {
            $subTask->update(['status' => MobileSubTaskStatus::STATUS_IN_PROGRESS]);
        } else {
            // 验收通过
            if (!isset($data['finish_type'])) {
                throw new InvalidParameterException('请选择任务完成情况');
            }
            $subTaskData = [
                'status' => MobileSubTaskStatus::STATUS_COMPLETED,
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
            $offsetFactor = MobileSubTask::getOffsetFactor($offsetDays);
            $subTaskData['offset_days'] = $offsetDays;
            $subTaskData['offset_factor'] = $offsetFactor;
            $subTask->update($subTaskData);
        }
    }

    /**
     * @param MobileSubTask $subTask
     * @param array $data
     * @throws InvalidParameterException
     */
    public function subTaskExpirationDate(MobileSubTask $subTask, array $data)
    {
        $appraisalData = $this->subTaskAppraisalData($data['standard_workload']);
        $subTask->update(array_merge($data, $appraisalData));
        if ($subTask->is_main == 1) {
            $subTask->task()->first()->update(['expiration_date' => $data['expiration_date']]);
        }
    }

    /**
     * @param MobileSubTask $subTask
     * @param array $data
     */
    public function subTaskUpdateVersion(MobileSubTask $subTask, array $data)
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
}
